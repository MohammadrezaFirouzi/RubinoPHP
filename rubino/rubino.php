<?php
require_once('./network/requests.php');




class RubinoPHP
{
    private $auth;
    private $client;

    public function __construct(string $auth)
    {
        $this->auth = $auth;
        $this->client = [
            "app_name" => "Main",
            "app_version" => "1.98.1",
            "package" => "m.rubika.ir",
            "platform" => "PWA"
        ];
    }


    private function run($input = [], string $method)
    {

        $data = [
            "auth" => $this->auth,
            "api_version" => "0",
            "client" => $this->client,
            "data" => $input,
            "method" => $method
        ];

        return request($data);
    }

    public function getPostByShareLink(string $post_url)
    {
        // The link of the post should be with HTTPS
        return self::run([
            "share_string" => str_replace("https://rubika.ir/post/", "", $post_url),
        ], "getPostByShareLink");
    }

    public function getProfileList($limit = 10)
    {
        return self::run([
            "limit" => $limit,
            "sort" => "FromMax"
        ], "getProfileList");
    }

    public function getRecentFollowingPosts($profile_id = null, $limit = 20)
    {
        return self::run([
            "profile_id" => $profile_id,
            "limit" => $limit,
            "sort" => "FromMax"
        ], "getProfileList");
    }


    public function getProfilesStories($profile_id = null)
    {
        return self::run([
            "profile_id" => $profile_id,
        ], "getProfilesStories");
    }

    public function follow($followee_id, $profile_id = null)
    {
        try {
            return self::run([
                "followee_id" => $followee_id,
                "f_type" => "Follow",
                "profile_id" => $profile_id
            ], "requestFollow");
        } catch (\Throwable $e) {
            return "پیج از قبل فالو شده است";
        }
    }

    public function Unfollow($followee_id, $profile_id = null)
    {
        return self::run([
            "followee_id" => $followee_id,
            "f_type" => "Unfollow",
            "profile_id" => $profile_id
        ], "requestFollow");
    }

    public function getProfileInfo($target_profile_id)
    {
        return self::run([
            "target_profile_id" => $target_profile_id,
        ], "getProfileInfo");
    }

    public function getProfilePosts($target_profile_id)
    {
        return self::run([
            "target_profile_id" => $target_profile_id,
        ], "getProfilePosts");
    }

    public function likePost($post_id, $post_profile_id)
    {
        return self::run([
            "post_id" => $post_id,
            "post_profile_id" => $post_profile_id,
            "action_type" => "Like"
        ], "likePostAction");
    }

    public function UnlikePost($post_id, $post_profile_id)
    {
        return self::run([
            "post_id" => $post_id,
            "post_profile_id" => $post_profile_id,
            "action_type" => "Like"
        ], "likePostAction");
    }

    public function getComments($profile_id, $post_id, $post_profile_id, $limit = 20)
    {
        return self::run([
            "profile_id" => $profile_id,
            "post_id" => $post_id,
            "post_profile_id" => $post_profile_id,
            "limit" => $limit,
            "sort" => "FromMax",
            "max_id" => null
        ], "getComments");
    }

    public function sendComment($text, $post_id, $post_profile_id, $profile_id = null)
    {
        return self::run([
            "content" => $text,
            "post_id" => $post_id,
            "post_profile_id" => $post_profile_id,
            "rnd" => rand(10000, 999999),
            "profile_id" => $profile_id,
        ], "addComment");
    }

    public function getExplorePosts($profile_id = null, $limit = 20)
    {
        return self::run([
            "profile_id" => $profile_id,
            "limit" => $limit,
            "sort" => "FromMax",
            "max_id" => null,
        ], "getExplorePosts");
    }

    public function getStoryIds($profile_id = null, $target_profile_id)
    {
        return self::run([
            "profile_id" => $profile_id,
            "target_profile_id" => $target_profile_id,
        ], "getStoryIds");
    }

    public function getStory($story_profile_id, $story_ids, $profile_id = null)
    {
        return self::run([
            "profile_id" => $profile_id,
            "story_profile_id" => $story_profile_id,
            "story_ids" => $story_ids
        ], "getStory");
    }

    public function savePost($post_id, $post_profile_id, $profile_id = null)
    {
        return self::run([
            "action_type" => "Bookmark",
            "post_id" => $post_id,
            "post_profile_id" => $post_profile_id,
            "profile_id" => $profile_id
        ], "postBookmarkAction");
    }

    public function addViewStory($story_profile_id, $story_ids)
    {
        return self::run([
            "story_profile_id" => $story_profile_id,
            "story_ids" => $story_ids,
        ], "addViewStory");
    }

    public function createPage($name, $username, $bio = null)
    {
        return self::run([
            "bio" => $bio,
            "name" => $name,
            "username" => $username
        ], "createPage");
    }

    public function addPostViewCount($post_id, $post_profile_id)
    {
        return self::run([
            "post_id" => $post_id,
            "post_profile_id" => $post_profile_id,
        ], "addPostViewCount");
    }

    public function getMyProfileInfo($profile_id = null)
    {
        return self::run([
            "profile_id" => $profile_id,
        ], "getMyProfileInfo");
    }

    public function getShareLink($post_id ,$post_profile_id ,$profile_id = null)
    {
        return self::run([
            "post_id" => $post_id,
            "post_profile_id"=> $post_profile_id,
            "profile_id" => $profile_id
        ], "getShareLink");
    }
}

?>


