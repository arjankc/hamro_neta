<?php

class Post extends BaseModel {
	protected $guarded = array();

	public static $rules = array(
        'title'   => 'required',
        'content' => 'required',
        'slug'    => 'required',
        // 'image'   => 'image',
        'user_id' => 'required',
    );

    public function validates()
    {
        $validation = Validator::make($this->attributes, static::$rules);

        if ($validation->passes()) return true;

        $this->errors = $validation->messages();

        return false;
    }

    // Find if any post have mentioned the candidate
    public static function is_candidate($id)
    {
        $posts = Post::all(['id', 'tags']);
        $ret = [];
        foreach ($posts as $post) {
            $tags = explode('-', $post->tags);
            if (in_array("$id", $tags)) {
                $ret[] = $post->id;
            }
        }
        return $ret;
    }
}
