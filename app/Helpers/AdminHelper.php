<?php

use App\SchoolBlock;
use App\Subject;
use App\Teacher;
use App\HocMaiClass;
use App\Livestream;
use App\LivestreamAnotherVideo;
use App\AnotherVideo;
use App\HocMaiAppVersion;
use APV\User;
use APV\User\Models\Role;
use App\HocmaiHeader;
use App\HocmaiFooter;
use App\UserFake;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

function checkUserRole()
{
    $user = getInforUser();
    return $user->role_id;
}

function getInforUser()
{
    $userInfo = Auth::user();
    if ($userInfo) {
        return $userInfo;
    }
    dd('login_error');
}

function getStatusLivestream($livestream)
{
    if ($livestream->livestream_status == PLAYING) {
        return '<span class="badge badge-primary">Đang phát</span>';
    }
    if ($livestream->livestream_status == PLAY_TIME_CLOCKER) {
        return '<span class="badge badge-danger">Hẹn giờ</span>';
    }
    if ($livestream->livestream_status == PLAY_FINISH) {
        return '<span class="badge badge-success">Phát xong</span>';
    }

}

function getIdFromSourceVideo($url)
{
    // $sourceId = substr($url, strpos($url, "id=") + NUMBER_SPLIT_ID);
    return $url;   
}

function getDurationVideoFromText($str)
{
    $data = explode(':', $str);
    $hour = $data[0];
    $minute = $data[1];
    $second = $data[2]; 
    $duration = 3600 * $hour + 60 * $minute + $second;
    return $duration;
}

function getListRole()
{
    return Role::pluck('name', 'id')->toArray();
}
/* start livestream hoc mai*/
// class lấy name lớp
function getListClass()
{
    $schoolblockId = getSchoolblockByUser();
    $roleId = checkUserRole();
    if (!$schoolblockId && $roleId == ADMIN) {
        return HocMaiClass::pluck('name','id')->toArray();
    }
    if (!$schoolblockId && $roleId != ADMIN) {
        dd('user bi sai quyen');
    }
    return HocMaiClass::where('schoolblock_id', $schoolblockId)->pluck('name','id')->toArray();
}
// khối 
function getListKhoi(){
    return SchoolBlock::pluck('name','id')->toArray();
}

function getListClassByBlock($id)
{
    $data = HocMaiClass::where('schoolblock_id', $id)->get();
    return $data;
}
// môn
function getListMon(){
    return Subject::pluck('name','id')->toArray();
}
function getListGv(){
    return Teacher::pluck('name','id')->toArray();
}
function getListUserFake(){
    return UserFake::pluck('fullname','id')->toArray();
}
// lấy name
function getClassNameById($id)
{
    $class = HocMaiClass::find($id);
    if ($class) {
        return $class->name;
    }
    return null;
}
function getMonNameById($id)
{
    $class = Subject::find($id);
    if ($class) {
        return $class->name;
    }
    return null;
}
function getKhoiNameById($id)
{
    $class = SchoolBlock::find($id);
    if ($class) {
        return $class->name;
    }
    return null;
}
function getGvNameById($id)
{
    $class = Teacher::find($id);
    if ($class) {
        return $class->name;
    }
    return null;
}
function getUrlSourceVideoId ($id){
    $sourceId = LivestreamAnotherVideo::where('livestream_id',$id)->pluck('another_video_id');
    //dd($sourceId);
    $url = AnotherVideo::find($sourceId);
    // dd($url);
    foreach($url as $videoId){
       return $videoId->id;
    }
    return null ;
}
// function getUrlSourceVideoId ($id){
//     $anotherVideoIds = LivestreamAnotherVideo::where('livestream_id',$id)->pluck('another_video_id');
//     $data = AnotherVideo::find($anotherVideoIds);
//     $result = [];
//     foreach ($data as $anotherVideo) {
//         $result[] = $anotherVideo->id;
//     }
// }
function getUrlSourceVideoName ($id){
    $sourceId = LivestreamAnotherVideo::where('livestream_id',$id)->pluck('another_video_id');
    $url = AnotherVideo::find($sourceId);
    //$result = [];
    foreach ($url as $anotherVideo) {
        return $anotherVideo->title;
    }
     return null;
}
 /* end livestream hoc mai*/
function getRoleNameById($id)
{
    $role = Role::find($id);
    if ($role) {
        return $role->name;
    }
    return null;
}
// name userfake
function getUserFakeNameById($id){
    $userFake = UserFake::find($id);
    if ($userFake) {
        return $userFake->fullname;
    }
    return null;
}
function getArrayStatus()
{
    return [0 => 'Không đăng nhập', 1 => 'Đăng nhập'];
}
function getLiveStreamsStatus(){
    $res = [
        IS_LIVESTREAM_TEST => 'Livestream video có sẵn',
        IS_LIVESTREAM_DIRECT => 'Livestream trực tiếp', 
    ];
    return $res;
}
function getListRepeat()
{
    $array = [
        1 => 'Lặp lại 1 lần',
        2 => 'Lặp lại 2 lần',
        3 => 'Lặp lại 3 lần'
    ];
    return $array;
}
function getNameRepeat($id)
{
    $repeat = Livestream::where('id',$id)->pluck('repeat');
    //dd($repeat);
    if ($repeat[0] == "1") {
        return "Lặp lại 1 lần";
    } else if ($repeat[0] == "2") {
        return "Lặp lại 2 lần";
    }else {
        return "Lặp lại 3 lần";
    }
    return "không lặp";
}
function getArrayIsPublish()
{
    $array = [
        IS_PUBLISH_ACTIVE => 'Đăng ngay',
        IS_PUBLISH_INACTIVE => 'Hẹn giờ',
    ];
    return $array;
}

function renderCodeOrder()
{
    $length = 16;
    $randstring = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
    return $randstring;
}
//phan quyền 
function getSchoolblockByUser()
{
    $roleId = checkUserRole();
    $blockId = null;
    if ($roleId == THPT) {
        $blockId = BLOCK_THPT;
    }
    if ($roleId == THCS) {
        $blockId = BLOCK_THCS;
    }
    if ($roleId == TH) {
        $blockId = BLOCK_TH;
    }
    return $blockId;

}
function getStatusHeaderFooter()
{
    return [
        APP_ACTIVE => 'Active',
        APP_INACTIVE => 'Inactive',
    ];
}

function getLivestreamUrl($sourceId)
{
    return url($sourceId);
    // https://drive.google.com/open?id=1R9qK03Ls3EClByk0FLj3mgJFweM7Klnj
    // $url = 'https://www.googleapis.com/drive/v3/files/' . $sourceId .'?alt=media&key=' . GOOGLE_API_KEY;
    $url = 'https://drive.google.com/uc?export=download&id=' . $sourceId;
    
    //dropbox: 'https://www.dropbox.com/s/bo8ipyxgxxicqgz/test.mp4?dl=1';
    //onedriver: https://onedrive.live.com/download?cid=646D0ECD2EF1B420&resid=646D0ECD2EF1B420%21361&authkey=ACIkwJZL1v05dos
    //googldriver: 'https://drive.google.com/uc?export=download&id=' . $sourceId;
    return $url;
}

function getUrlFull($path)
{
    $url = url($path);
    return $url;
}

function apiStatusLivestream($livestreamStartTime, $livestreamEndTime)
{
    $now = Carbon::now();
    $now = $now->toDateTimeString();
    $timeNow = strtotime($now);
    $data = [];
    if ($livestreamStartTime < $timeNow && $timeNow < $livestreamEndTime) {
        $data['livestream_status'] = PLAYING;
        $data['livestream_status_name'] = 'Đang phát';
    }
    if ($timeNow < $livestreamStartTime) {
        $data['livestream_status'] = PLAY_TIME_CLOCKER;
        $data['livestream_status_name'] = 'Đang chờ';
    }
    if ($timeNow > $livestreamEndTime) {
        $data['livestream_status'] = PLAY_FINISH;
        $data['livestream_status_name'] = 'Phát xong';
    }
    return $data;
}

function getDurationLivestream($livestreamId)
{
    $listId = LivestreamAnotherVideo::where('livestream_id', $livestreamId)->pluck('another_video_id');
    $result = AnotherVideo::whereIn('id', $listId)->sum('duration');
    return $result;
}

function getTimeLivestreamPlay($livestream)
{
    if ($livestream->status_time == IS_PUBLISH_ACTIVE) {
        $time = $livestream->created_at;
    }
    if ($livestream->status_time == IS_PUBLISH_INACTIVE) {
        $time = $livestream->timer_clock;
    }
    return $time;
}

function getTimePlayLivestream($livestream)
{
    $time = getTimeLivestreamPlay($livestream);
    return strtotime($time);
}

function getEndTimeLivestream($value)
{
    $duration = getDurationLivestream($value->id);
    $livestreamStartTime = getTimePlayLivestream($value);
    $livestreamEndTime = $livestreamStartTime + $duration;
    return $livestreamEndTime;
}

function getNameOS($os)
{
    if ($os == IOS) {
        return 'IOS';
    }
    if ($os == ANDROID) {
        return 'ANDROID';
    }
    return 'Hệ điều hành khác';
}

function convertTimeFormat($string)
{
    $res = date("d-m-Y H:i:s", strtotime($string));
    return $res;
}

function getAppOs()
{
    $data = [
        APP_IOS_ID => 'IOS',
        APP_ANDROID_ID => 'ANDROID',
    ];
    return $data;
}

function getNameStatusAppVersion($status)
{
    $data = getStatusHeaderFooter();
    if (isset($data[$status])) {
        return $data[$status];
    }
    return null;
}
function getVersion()
{
    $result = DB::table('app_versions')->select(DB::raw('app_version '))
    ->groupBy('app_version')
    ->havingRaw('COUNT(app_version)>= 1')
    ->get();
    return $result;
}
// app
function getApp()
{
    $data = [
        ''=>'Tất cả',
        APP_IOS_ID => 'IOS',
        APP_ANDROID_ID => 'ANDROID',
    ];
    return $data;
}
function getStatus(){
    $data = [
        ''=>'Tất cả',
        1 => 'Active',
        0 => 'Inactive',
    ];
    return $data;
}