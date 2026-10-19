<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Hosting;
use App\Models\Server;
use App\Models\EmailService;
use App\Http\Requests\FaqRequest;
use Illuminate\Http\Request;

class FAQController extends Controller
{

    public function byHosting(Request $request, Hosting $hosting)
    {
        $faqs = Faq::where('common_id', $hosting->id)
            ->where('common_type', Hosting::class)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = (Faq::where('common_id', $hosting->id)
            ->where('common_type', Hosting::class)
            ->max('sort_order') ?? 0) + 1;

        $server = null;
        $emailService = null;

        return view('admin.faq.index', compact('faqs', 'hosting', 'nextSortOrder', 'server', 'emailService'));
    }

    public function byServer(Request $request, Server $server)
    {
        $faqs = Faq::where('common_id', $server->id)
            ->where('common_type', Server::class)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = (Faq::where('common_id', $server->id)
            ->where('common_type', Server::class)
            ->max('sort_order') ?? 0) + 1;

        $hosting = null;
        $emailService = null;

        return view('admin.faq.index', compact('faqs', 'server', 'nextSortOrder', 'hosting', 'emailService'));
    }

    public function byEmailService(Request $request, EmailService $emailService)
    {
        $faqs = Faq::where('common_id', $emailService->id)
            ->where('common_type', EmailService::class)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = (Faq::where('common_id', $emailService->id)
            ->where('common_type', EmailService::class)
            ->max('sort_order') ?? 0) + 1;

        $hosting = null;
        $server = null;

        return view('admin.faq.index', compact('faqs', 'emailService', 'nextSortOrder', 'hosting', 'server'));
    }

    public function index(Request $request)
    {
        $faqs = Faq::when($request->search, function ($q) use ($request) {
            $q->where('question', 'like', '%' . $request->search . '%');
        })
        ->orderBy('sort_order')
        ->paginate(10);

        $nextSortOrder = (Faq::max('sort_order') ?? 0) + 1;
        $hosting = null;
        $server = null;

        return view('admin.faq.index', compact('faqs', 'nextSortOrder', 'hosting', 'server'));
    }


    public function create()
    {
        $nextSortOrder = (Faq::max('sort_order') ?? 0) + 1;
        $faqs = Faq::orderBy('sort_order')->paginate(10);
        $hosting = null;
        $server = null;

        return view('admin.faq.index', compact('nextSortOrder', 'faqs', 'hosting', 'server'));
    }


    public function store(FaqRequest $request)
    {
        $data = $request->validated();

        $data['sort_order'] ??= (Faq::where('common_id', $data['common_id'])
            ->where('common_type', $data['common_type'])
            ->max('sort_order') ?? 0) + 1;

        $data['is_active'] = (bool) $request->input('is_active', 0);

        Faq::create($data);

        return back()->with('success', 'FAQ Added Successfully');
    }


    public function edit(Faq $faq, Request $request)
    {
        $editFaq = $faq;
        $faqs = Faq::where('common_id', $faq->common_id)
            ->where('common_type', $faq->common_type)
            ->orderBy('sort_order')
            ->paginate(10);

        $nextSortOrder = $faq->sort_order;

        $hosting = null;
        if ($request->query('hosting')) {
            $hosting = Hosting::find($request->query('hosting'));
        }

        $server = null;
        if ($request->query('server')) {
            $server = Server::find($request->query('server'));
        }

        $emailService = null;
        if ($request->query('email_service')) {
            $emailService = EmailService::find($request->query('email_service'));
        } elseif ($faq->common_type === EmailService::class) {
            $emailService = EmailService::find($faq->common_id);
        }

        return view('admin.faq.index', compact('editFaq', 'faqs', 'nextSortOrder', 'hosting', 'server', 'emailService'));
    }


    public function update(FaqRequest $request, Faq $faq)
    {
        $data = $request->validated();

        $data['is_active'] = (bool) $request->input('is_active', 0);

        $faq->update($data);

        return back()->with('success', 'FAQ Updated Successfully');
    }


    public function destroy(Faq $faq)
    {
        $faq->delete();

        return back()->with('success', 'FAQ Deleted Successfully');
    }

}
