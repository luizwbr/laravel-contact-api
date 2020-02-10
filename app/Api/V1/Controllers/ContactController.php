<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController;
use App\Contact;
use Validator;

/**
 * Contact Controller
 * 
 * @author Luiz Felipe Weber <luiz.weber@pm.me>
 * @since 1.0.0
 */
class ContactController extends ResponseController
{
    private function _validate($input) 
    {
        $validator = Validator::make($input, [
            'name' => 'required',
            'lastname' => 'required',
            'email' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        return false;
    }

    /**
     * Get all Contacts
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $contacts = Contact::all();
        return $this->sendItems($contacts->toArray(), count($contacts));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $input = $request->all();
        $errors = $this->_validate($input);
        if ($errors) {
            return $errors;
        }
        return Contact::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return $this->sendError('Contact not found.');
        }
        return $contact;        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return $this->sendError('Contact not found.');
        }

        $input = $request->all();
        $errors = $this->_validate($input);
        if ($errors) {
            return $errors;
        }

        $contact->name      = $input['name'];
        $contact->lastname  = $input['lastname'];
        $contact->email     = $input['email'];
        $contact->phone     = $input['phone'];
        $contact->save();

        return $this->sendResponse('Contact updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return $this->sendError('Contact not found.');
        }
        $contact->delete();

        return 204;        
    }
}
