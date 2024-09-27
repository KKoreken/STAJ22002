<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class FullCalenderController extends Controller
{
    public function index()
    {
        return view('fullcalender');
    }

    public function loadEvents(Request $request)
    {

        if ($request->ajax()) {
            // Etkinlikleri çek
            $events = Event::all(['id', 'title', 'start', 'end', 'startHour']);

            $data = [];
            foreach ($events as $event) {
                // Start ve end tarihlerini birleştirerek tam tarih-saat formatına dönüştür
                $startDateTime = $event->start . ' ' . $event->startHour;
                $endDateTime = $event->end . ' ' . $event->startHour;

                // Verileri FullCalendar formatına dönüştürerek diziye ekle
                $data[] = [
                    'id' => $event->id,
                    'title' => $event->title,
                    'start' => $startDateTime, // Tam tarih-saat başlangıç
                    'end' => $endDateTime, // Tam tarih-saat bitiş
                ];
            }

            return response()->json($data);
        }
    }

    public function ajax(Request $request)
    {
        switch ($request->type) {
            case 'add':
                $event = Event::create([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'update':
                $event = Event::find($request->id)->update([
                    'title' => $request->title,
                    'start' => $request->start,
                    'end' => $request->end,
                ]);

                return response()->json($event);
                break;

            case 'delete':
                $event = Event::find($request->id)->delete();

                return response()->json($event);
                break;

            default:
                break;
        }
    }
}
