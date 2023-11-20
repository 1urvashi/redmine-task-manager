<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class TaskController extends Controller
{
    private $redmineUrl;
    private $redmineApiKey;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->redmineUrl = config('redmine.api_url');
            $this->redmineApiKey = config('redmine.api_key');
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        // Fetch tasks from Redmine API
        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $this->redmineApiKey,
            'Content-Type' => 'application/json',
        ])->get("{$this->redmineUrl}/issues.json");

        $redmineTasks = $response->json()['issues'];

        $search = $request->input('search');

        // Apply search filter
        $tasks = Task::when($search, function ($query) use ($search) {
            $query->where('subject', 'like', "%$search%");
        })->paginate(10);

        return view('tasks.index', compact('redmineTasks'));
    }

    public function show($taskId)
    {
        // Fetch details of a specific task from Redmine API
        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $this->redmineApiKey,
            'Content-Type' => 'application/json',
        ])->get("{$this->redmineUrl}/issues/{$taskId}.json");

        $redmineTask = $response->json()['issue'];

        return view('tasks.show', compact('redmineTask'));
    }

    public function create()
    {
        return view('tasks.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
                    'title' => 'required|string|max:255',
                    'description' => 'required',
                    'project_id' => 'required',
                    'company_id' => 'required',
                ]);

        // Create a new task in Redmine
        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $this->redmineApiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->redmineUrl}/issues.json", [
            'issue' => [                
                'title' => $request->input('title'),
                'description' => $request->input('description'),
                'project_id' => $request->input('project_id'),
            ],
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully');
    }

    
    public function delete($taskId)
    {
        // Delete task in Redmine
        $response = Http::withHeaders([
            'X-Redmine-API-Key' => $this->redmineApiKey,
            'Content-Type' => 'application/json',
        ])->delete("{$this->redmineUrl}/issues/{$taskId}.json");

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }
}
