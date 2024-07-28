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

        return sendRequest($data);
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

    public function getShareLink($post_id, $post_profile_id, $profile_id = null)
    {
        return self::run([
            "post_id" => $post_id,
            "post_profile_id" => $post_profile_id,
            "profile_id" => $profile_id
        ], "getShareLink");
    }

    public function request_upload_file($file_name, $file_type, $profile_id)
    {
        return self::run([
            "file_name" => $file_name,
            "file_size" => filesize($file_name),
            "file_type" => $file_type,
            "profile_id" => $profile_id
        ], "requestUploadFile");
    }

    public function uploadFile($file, $profile_id, $file_type, $file_name = null, $chunk = 1048576, $callback = null)
    {
        $pr = self::request_upload_file($file, $file_type, $profile_id)['data'];

        $chunk_size = 131072;
        $file_content = file_get_contents($file);
        $total_parts = (int) ceil(strlen($file_content) / $chunk_size);

        for ($part_number = 1; $part_number <= $total_parts; $part_number++) {
            $start = ($part_number - 1) * $chunk_size;
            $end = min($part_number * $chunk_size, strlen($file_content));
            $data = substr($file_content, $start, $end - $start);
            $headers = array(
                'Host: ' . str_replace("/UploadFile.ashx", "", str_replace("https://", "", $pr['server_url'])),
                'Connection: keep-alive',
                'Content-Length: ' . strval(strlen($data)),
                'Content-Type: application/octet-stream',
                'auth: ' . $this->auth,
                'file-id: ' . $pr["file_id"],
                'total-part: ' . strval($total_parts),
                'part-number: ' . strval($part_number),
                'hash-file-request: ' . $pr["hash_file_request"],
                'user-agent: okhttp/3.12.12',

            );

            $options = array(
                CURLOPT_URL => $pr['server_url'],
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_POSTFIELDS => $data,
                CURLOPT_HTTPHEADER => $headers
            );

            $curl = curl_init();
            curl_setopt_array($curl, $options);
            $response = json_decode(curl_exec($curl), true);

            curl_close($curl);
            if ($response['data'] != null) {
                return array($response['data']['hash_file_receive'], $pr['file_id']);
            }
        }
    }

    private function add_post($file, $caption, $file_type, $profile_id, $tumb_image = null, $duration = null)
    {
        $payload = [
            'rnd' => rand(10000, 99999),
            'width' => 720,
            'height' => 720,
            'caption' => $caption,
            'post_type' => $file_type,
            'profile_id' => $profile_id,
            'is_multi_file' => false,
        ];
        $result = self::uploadFile($file, $profile_id, $file_type);

        $payload['file_id'] = $result[1];
        $payload['hash_file_receive'] = $result[0];
        $payload['thumbnail_file_id'] = $result[1];
        $payload['thumbnail_hash_file_receive'] = $result[0];
        if ($file_type == "Picture" && $tumb_image != null) {
            $result_upload_thumb = self::uploadFile($tumb_image, $profile_id, 'Picture');
            $payload['thumbnail_file_id'] = $result_upload_thumb[1];
            $payload['thumbnail_hash_file_receive'] = $result_upload_thumb[0];
        }

        if ($file_type == "Video") {

            $result_upload_thumb = self::uploadFile($tumb_image, $profile_id, 'Picture');
            $payload['thumbnail_file_id'] = $result_upload_thumb[1];
            $payload['thumbnail_hash_file_receive'] = $result_upload_thumb[0];
            $payload['snapshot_file_id'] = $result_upload_thumb[1];
            $payload['snapshot_hash_file_receive'] = $result_upload_thumb[0];
            $payload['duration'] = $duration;
        }

        return self::run($payload, "addPost");
    }


    private function add_story($file, $file_type, $profile_id, $tumb_image = null, $duration = null)
    {   
        /** */
       
        $payload = [
            'rnd' => rand(10000, 99999),
            'width' => 720,
            'height' => 1280,
            'story_type' => $file_type,
            'profile_id' => $profile_id,
        ];
        $result = self::uploadFile($file, $profile_id, $file_type);

        $payload['file_id'] = $result[1];
        $payload['hash_file_receive'] = $result[0];
        $payload['thumbnail_file_id'] = $result[1];
        $payload['thumbnail_hash_file_receive'] = $result[0];
        if ($file_type == "Picture" && $tumb_image != null) {
            $result_upload_thumb = self::uploadFile($tumb_image, $profile_id, 'Picture');
            $payload['thumbnail_file_id'] = $result_upload_thumb[1];
            $payload['thumbnail_hash_file_receive'] = $result_upload_thumb[0];
        }

        if ($file_type == "Video") {

            $result_upload_thumb = self::uploadFile($tumb_image, $profile_id, 'Picture');
            $payload['thumbnail_file_id'] = $result_upload_thumb[1];
            $payload['thumbnail_hash_file_receive'] = $result_upload_thumb[0];
            $payload['snapshot_file_id'] = $result_upload_thumb[1];
            $payload['snapshot_hash_file_receive'] = $result_upload_thumb[0];
            $payload['duration'] = $duration;
        }

        return self::run($payload, "addStory");
    }

    public function add_video_post($file, $caption, $profile_id, $tumb_image, $duration = 1)
    {

        if (!is_file($file)) {
            die("file is not Found");
        }

        if (is_null($file)) {
            die("Please Set tumb_image Value");
        }

        return self::add_post($file, $caption, 'Video', $profile_id, $tumb_image, $duration);
    }

    public function add_photo_post($file, $caption, $profile_id, $tumb_image = null)
    {

        if (!is_file($file)) {
            die("file is not Found");
        }

        return self::add_post($file, $caption, 'Picture', $profile_id, $tumb_image);
    }

    public function add_video_story($file, $profile_id, $tumb_image, $duration = 1)
    {

        if (!is_file($file)) {
            die("file is not Found");
        }

        if (is_null($file)) {
            die("Please Set tumb_image Value");
        }

        return self::add_story($file, 'Video', $profile_id, $tumb_image, $duration);
    }

    public function add_photo_story($file, $profile_id, $tumb_image = null)
    {

        if (!is_file($file)) {
            die("file is not Found");
        }

        return self::add_story($file,'Picture', $profile_id, $tumb_image);
    }

    
}
