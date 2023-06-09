<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\RoomItem;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoomItemController extends Controller
{
    public function getListAction(): Response
    {
        if (auth()->user()->isSuperUser()) {
            $response = RoomItem::query();
        } else {
            $response = RoomItem
                ::whereIn('project_id', auth()->user()->projectsAllowedForAdministrationIds());
        }

        $response = $response->with('project')->paginate(10);

        return response([
            'items' => $response->items(),
            'pagination' => [
                'currentPage' => $response->currentPage(),
                'perPage' => $response->perPage(),
                'total' => $response->total(),
            ]
        ]);
    }

    public function getAction(int $id): Response
    {
        return response(
            RoomItem::where(['id' => $id])->first()
        );
    }

    public function createAction(Request $request): Response
    {
        $request->validate([
            'active' => 'required|boolean',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'project_id' => 'required|integer|exists:projects,id',
        ]);

        $roomItem = RoomItem::create([
            'active' => $request->active,
            'name' => $request->name,
            'type' => $request->type,
            'project_id' => $request->project_id,
        ]);

        return response($roomItem);
    }

    public function updateAction(Request $request): Response
    {
        $request->validate([
            'id' => 'required|integer|exists:room_items,id',
            'active' => 'required|boolean',
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
        ]);

        $roomItem = RoomItem::findOrFail($request->id);

        $roomItem->active = $request->active;
        $roomItem->name = $request->name;
        $roomItem->type = $request->type;

        $roomItem->save();

        return response($roomItem);
    }
}
