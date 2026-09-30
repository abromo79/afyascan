<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactMessageController extends Controller
{
    public function index(Request $request): View
    {
        $filter = $request->input('filter', 'active');

        $messages = ContactMessage::query()
            ->when($filter === 'active', fn ($query) => $query->active())
            ->when($filter === 'unread', fn ($query) => $query->active()->unread())
            ->when($filter === 'archived', fn ($query) => $query->where('is_archived', true))
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.messages.index', [
            'messages' => $messages,
            'filter' => $filter,
        ]);
    }

    public function show(ContactMessage $message): View
    {
        if (! $message->is_read) {
            $message->update(['is_read' => true]);
        }

        return view('admin.messages.show', [
            'message' => $message,
        ]);
    }

    public function update(Request $request, ContactMessage $message): RedirectResponse
    {
        $request->validate([
            'is_read' => ['nullable', 'boolean'],
            'is_replied' => ['nullable', 'boolean'],
            'is_archived' => ['nullable', 'boolean'],
        ]);

        $message->update([
            'is_read' => $request->boolean('is_read'),
            'is_replied' => $request->boolean('is_replied'),
            'is_archived' => $request->boolean('is_archived'),
        ]);

        return back()->with('success', 'Message updated.');
    }

    public function destroy(ContactMessage $message): RedirectResponse
    {
        $message->delete();

        return redirect()->route('admin.messages.index')->with('success', 'Message deleted.');
    }
}
