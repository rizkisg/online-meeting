<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;

class MeetingController extends Controller
{
    // Fungsi untuk membuat meeting baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required',
            'start_time' => 'required|date',
        ]);

        // Simpan data meeting ke database
        $meeting = Meeting::create($validated);

        return response()->json([
            'message' => 'Meeting created successfully',
            'meeting' => $meeting
        ], 201);
    }

    // Fungsi untuk mengambil semua meeting
    public function index()
    {
        $meetings = Meeting::all();

        return response()->json($meetings);
    }

    // Fungsi untuk melihat detail meeting berdasarkan ID
    public function show($id)
    {
        $meeting = Meeting::findOrFail($id);

        return response()->json($meeting);
    }
}
