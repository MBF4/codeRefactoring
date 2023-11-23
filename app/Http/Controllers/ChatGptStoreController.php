<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreChatRequest;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;
use OpenAI\Laravel\Facades\OpenAI;

class ChatGptStoreController extends Controller
{
    public function __invoke(StoreChatRequest $request, string $id = null)
    {
        $messages = [];
        if ($id) {
            $chat = Chat::findOrFail($id);
            $messages = $chat->context;
        }
        
        $messages[] = ['role' => 'user', 'content' =>' Refactor this code to adhere to best coding standards, make it more readable, and  maintainable and fix any bugs ' . $request->input('promt')];

        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => $messages
        ]);
        
          $assistant_content = $response->choices[0]->message->content;

            // Identify and extract code blocks
            preg_match_all('/```(.*?)```/s', $assistant_content, $code_blocks);

            // Remove code blocks from the assistant's content
            $non_code_content = preg_replace('/```(.*?)```/s', '', $assistant_content);

            // Split non-code content into sentences
            $text_lines = preg_split('/(?<=[.!?])\s+/', $non_code_content);

            // Add each sentence as a separate message
            foreach ($text_lines as $line) {
                if (trim($line) !== '') {
                    $messages[] = ['role' => 'assistant', 'content' => $line];
                }
            }

    // Combine all code blocks into a single message, preserving newlines
    $combined_code_blocks = implode("\n\n", $code_blocks[1]);
    if (trim($combined_code_blocks) !== '') {
        $messages[] = ['role' => 'assistant', 'content' => "```\n$combined_code_blocks\n```"];
    }

        $chat = Chat::updateOrCreate(
            [
                'id' => $id,
                'user_id' => Auth::id()
            ],
            [
                'context' => $messages
            ]
        );

        return redirect()->route('chat.show', [$chat->id]);
    }
}

