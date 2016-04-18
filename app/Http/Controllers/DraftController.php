<?php

namespace App\Http\Controllers;

use Auth;
use App\Models\Post\Draft;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Requests\CreatePostRequest as CreatePostRequest;

use App\Http\Requests;

class DraftController extends Controller
{
    private $MESSAGE_ERROR_PERMISSIONS = "You don't have the required permissions";

    /**
     * DraftController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Creates a new Draft using the submitted data
     *
     * @param CreatePostRequest $request
     * @return Redirect to user's draft page with success message
     */
    public function store(CreatePostRequest $request) {
        $request['author_id'] = Auth::id();
        Draft::create($request->all());
        return redirect()->action('UserController@getUserDrafts', [Auth::id()])->with('message-success', 'Draft saved successfully');
    }

    /**
     * Returns the view to edit a Draft
     *
     * @param $id Draft to edit
     * @return Redirect
     */
    public function edit($id) {
        $draft = $this->getDraftOrFail($id);
        if($this->isDraftFromCurrentUser($draft)) {
            return view('drafts.edit')->with('draft', $draft);
        } else {
            return $this->returnWithInsufficientPermissions();
        }
    }

    /**
     * Updates a Draft using the submitted data
     *
     * @param CreatePostRequest $request
     * @param Draft $draft
     * @return Redirect
     */
    public function update(CreatePostRequest $request, Draft $draft) {
        if($this->isDraftFromCurrentUser($draft)) {
            $request->author_id = $draft->author_id;
            $draft->update($request->all());
            return redirect()->action('UserController@getUserDrafts', [Auth::id()])->with('message-success', 'Draft updated successfully');
        }
        return $this->returnWithInsufficientPermissions();
    }

    public function publish(CreatePostRequest $request, Draft $draft) {
        if($this->isDraftFromCurrentUser($draft)) {
            $draft->update($request->all());
            $post = $draft->publish();
            return redirect('/post/'.$post->slug)->with('message-success', 'Draft published successfully');
        }
    }

    /**
     * Destroys a Draft
     *
     * @param $id
     * @return mixed
     */
    public function destroy($id) {
        $draft = $this->getDraftOrFail($id);
        if($this->isDraftFromCurrentUser($draft)) {
            $draft->delete();
            return redirect('home')->with('message-success', 'Draft removed successfully');
        } else {
            $this->returnWithInsufficientPermissions();
        }
    }

    /**
     * Find a Draft or throws an exception
     *
     * @param $id Draft to find
     * @throws ModelNotFoundException
     * @return Draft
     */
    private function getDraftOrFail($id) {
        return Draft::findOrFail($id);
    }

    /**
     * Retuns to home with error message
     *
     * @return Redirect home withj error message
     */
    private function returnWithInsufficientPermissions() {
        return redirect('/')->with('message', $this->MESSAGE_ERROR_PERMISSIONS);
    }

    /**
     * Checks if the Draft belongs to the current user
     *
     * @param Draft $draft
     * @return bool
     */
    private function isDraftFromCurrentUser(Draft $draft) {
        return $draft->getAuthor->id === Auth::id();
    }
}
