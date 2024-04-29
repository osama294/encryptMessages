<?php

namespace App\Http\Controllers;
use App\Models\Message;
use App\Services\EncryptionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MessageController
{
    protected $encryptionService;

public function __construct(EncryptionService $encryptionService)
    {
        $this->encryptionService = $encryptionService;
    }


    public function store(Request $request)
    {
        $encryptedMessage = $this->encryptionService->encrypt($request->message);

        $secretCode = $this->generateSecretCode($request->recipient, $request->recipient_identifier);

        $message = new Message([
            'recipient_id' => $request->recipient,
            'recipient_identifier' => $request->recipient_identifier,
            'encrypted_message' => $encryptedMessage,
            'expires_at' => now()->addMinutes((int)$request->expiryMinutes),
            'secret_code' => $secretCode,
        ]);
        $message->save();

        // Show the secret code in an alert
        return redirect()->route('messages.success')->with('secret_code', $secretCode);
    }





    public function retrieve(Request $request)
    {
        try {
            // Check if identifier and secretCode are provided in the request
            if (!$request->has('identifier') || !$request->has('secretCode')) {
                abort(400, 'Bad Request');
            }

            $recipientName = $request->identifier;
            $secretCode = $request->secretCode;

            // Split the secret code into recipient name hash and identifier hash
            $parts = explode(':', $secretCode);

            // Check if secret code is in the correct format
            if (count($parts) !== 2) {
                abort(400, 'Bad Request');
            }

            $recipientNameHash = $parts[0];
            $recipientIdentifierHash = $parts[1];

            // Compare recipient name hash
            if (Crypt::decryptString($recipientNameHash) !== $recipientName) {
                // Recipient name doesn't match
                abort(403, 'Unauthorized');
            }

            // Decrypt messages
            $recipientIdentifier = Crypt::decryptString($recipientIdentifierHash);

            // Check if decryption is successful
            if (!$recipientIdentifier) {
                abort(400, 'Bad Request');
            }

            $messages = Message::where('recipient_identifier', $recipientIdentifier)->get();

            $decryptedMessages = $messages->map(function ($msg) {
                try {
                    // Decrypt message
                    $decryptedMessage = $this->encryptionService->decrypt($msg->encrypted_message);

                    // Delete the message after decryption
                    $msg->delete();

                    // Return decrypted message
                    return $decryptedMessage;
                } catch (Exception $e) {
                    // Log decryption error
                    \Log::error('Error decrypting message: ' . $e->getMessage());
                    // Return empty string or handle the error as per your requirement
                    return '';
                }
            });

            return view('messages.show', ['messages' => $decryptedMessages]);
        } catch (Exception $e) {
            // Log any unexpected errors
            \Log::error('Error in retrieve method: ' . $e->getMessage());
            // Return an error response
            abort(500, 'Internal Server Error');
        }
    }


    private function generateSecretCode(string $recipientName, string $recipientIdentifier): string
    {
        $recipientNameHash = Crypt::encryptString($recipientName);
        $recipientIdentifierHash = Crypt::encryptString($recipientIdentifier);
        return $recipientNameHash . ':' . $recipientIdentifierHash;
    }

    private function checkExpiry(Message $message): bool
    {
        return $message->expires_at && $message->expires_at < now();
    }
}
