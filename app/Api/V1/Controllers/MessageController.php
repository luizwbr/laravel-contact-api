<?php

namespace App\Api\V1\Controllers;

use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Http\Request;
use App\Http\Controllers\API\ResponseController;
use App\Message;
use Validator;

/**
 * Message Controller
 * 
 * @author Luiz Felipe Weber <luiz.weber@pm.me>
 * @since 1.0.0
 */
class MessageController extends ResponseController
{
    private function _validate($input) 
    {
        $validator = Validator::make($input, [
            'contact_id' => 'required',
            'description' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        return false;
    }

    /**
     * Get all Messages
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function all()
    {
        $messages = Message::all();
        return $this->sendItems($messages->toArray(), count($messages));
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
        return Message::create($input);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        $message = Message::find($id);
        if (is_null($message)) {
            return $this->sendError('Message not found.');
        }
        return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function findByFk($id)
    {
        $messages = Message::where('contact_id', $id)->get();
        return $this->sendItems($messages->toArray(), count($messages));
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
        $message = Message::find($id);
        if (is_null($message)) {
            return $this->sendError('Message not found.');
        }

        $input = $request->all();
        $errors = $this->_validate($input);
        if ($errors) {
            return $errors;
        }

        $message->contact_id    = $input['contact_id'];
        $message->description   = $input['description'];
        $message->save();

        return $this->sendResponse('Message updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $id)
    {
        $message = Message::find($id);
        if (is_null($message)) {
            return $this->sendError('Message not found.');
        }
        $message->delete();

        return 204;        
    }
}
