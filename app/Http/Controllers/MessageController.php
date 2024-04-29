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

        $message = new Message([
            'recipient_id' => $request->recipient,
            'recipient_identifier' => $request->recipient_identifier,
            'encrypted_message' => $encryptedMessage,
            'expires_at' => now()->addMinutes((Int)$request->expiryMinutes),
            'secret_code' => $this->generateSecretCode($request->recipient,$request->recipient_identifier),
        ]);
        $message->save();

        return response()->json(['message' => 'Message saved']);
    }




    public function retrieve(Request $request)
    {
        $recipientName = $request->identifier;
        $secretCode = $request->secretCode;

        // Split the secret code into recipient name hash and identifier hash
        $parts = explode(':', $secretCode);
        $recipientNameHash = $parts[0];
        $recipientIdentifierHash = $parts[1];

        // Compare recipient name hash
        if (Crypt::decryptString($recipientNameHash) !== $recipientName) {
            // Recipient name doesn't match
            abort(403, 'Unauthorized');
        }


        // Decrypt messages
        $messages = Message::where('recipient_identifier', Crypt::decryptString($recipientIdentifierHash))->get();

        $decryptedMessages = $messages->map(function ($msg) {
            // Decrypt message
            $decryptedMessage = $this->encryptionService->decrypt($msg->encrypted_message);

            // Delete the message after decryption
            $msg->delete();

            // Return decrypted message
            return $decryptedMessage;
        });

        return view('messages.show', ['messages' => $decryptedMessages]);
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
