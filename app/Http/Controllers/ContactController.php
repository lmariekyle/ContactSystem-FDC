<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_contacts = Contact::where('user_id',auth()->id())->paginate(5);

        return view('contactpage', compact('user_contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contact.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $user = auth()->id();
        Contact::create([
            'user_id' => $request->user_id,
            'name' => $request->name,
            'company' => $request->company,
            'email'  => $request->email,
            'phone' => $request->phone,
        ]);

        return redirect()->route('contacts.index')
                         ->with('success', 'Contact created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
 
    }

    public function search(Request $request)
    {
        if($request->ajax())
        {
            $output = '';
            $query = $request->get('query');
            if($query != '') {
                $data = DB::table('contacts')
                    ->where('name', 'like', '%'.$query.'%')
                    ->orWhere('company', 'like', '%'.$query.'%')
                    ->orWhere('phone', 'like', '%'.$query.'%')
                    ->orWhere('email', 'like', '%'.$query.'%')
                    ->get();
                    
            } else {
                $data = DB::table('contacts')
                    ->orderBy('id', 'asc')
                    ->get();
            }
             
            $total_row = $data->count();
            if($total_row > 0){
                foreach($data as $row)
                {
                    $output .= '
                    <tr>
                    <td>'.$row->name.'</td>
                    <td>'.$row->company.'</td>
                    <td>'.$row->phone.'</td>
                    <td>'.$row->email.'</td>
                    <td>
                        <a href="' . route('contacts.edit', $row->id) . '" class="btn btn-sm btn-primary">Edit</a>
                        <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal' . $row->id . '">Delete</button>

                        <!-- Modal -->
                        <div class="modal fade" id="deleteModal' . $row->id . '" tabindex="-1" aria-labelledby="deleteModalLabel' . $row->id . '" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel' . $row->id . '">Confirm Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this contact?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form action="' . route('contacts.destroy', $row->id) . '" method="POST" style="display: inline;">
                                            ' . csrf_field() . '
                                            ' . method_field('DELETE') . '
                                            <button type="submit" class="btn btn-danger">Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    </tr>
                    ';
                }
            } else {
                $output = '
                <tr>
                    <td align="center" colspan="5">No Data Found</td>
                </tr>
                ';
            }
            $data = array(
                'table_data'  => $output,
                'total_data'  => $total_row
            );
            echo json_encode($data);
        }
    }
    


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('contact.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        $contact->update([
            'name' => $request->name,
            'company' => $request->company,
            'phone' => $request->phone,
            'email' => $request->email,
        ]);

        $contact->save();
        return redirect()->route('contacts.index')
        ->with('success', 'Contact updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('contacts.index')
                         ->with('success', 'Contact deleted successfully.');
    }
}
