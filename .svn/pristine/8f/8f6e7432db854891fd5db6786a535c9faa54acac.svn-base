<?php

use App\Models\Permission;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Str;

function welcome_word()
{

    $return = '';
    /* This sets the $time variable to the current hour in the 24 hour clock format */
    $time = date("H");
    /* If the time is less than 1200 hours, show good morning */
    if ($time < "12") {
        $return =  "Good Morning, and have a nice day 🤗";
    } else
        /* If the time is grater than or equal to 1200 hours, but less than 1700 hours, so good afternoon */
        if ($time >= "12" && $time < "15") {
            $return =  "Good Afternoon, and have a nice day 😇";
        } else
            /* Should the time be between or equal to 1700 and 1900 hours, show good evening */
            if ($time >= "15" && $time < "19") {
                $return = "Good Afternoon. Hope you have an afternoon as lovely as you are 🥰";
            } else
                /* Finally, show good night if the time is greater than or equal to 1900 hours */
                if ($time >= "19") {
                    $return =  "Good Evening, and keep spirit! 😆";
                }

    return ($return);
}

// Toaster
function toaster($msg, $type, $title)
{
    return array(
        'title'         => $title,
        'message'       => $msg,
        'alert-type'    => $type
    );
}

function SVGI($name)
{
    return svg($name)->contents;
}

function ButtonSED($data, $route_type, $permission_type, $show = true)
{
    $button = '';
    if ($show) {
        $button .= '<a href="' . route($route_type . '.show', $data->id) . '" class="btn btn-icon btn-warning btn-sm"  data-toggle="tooltip" title="Show">
            ' . SVGI('bi-eye') . '
        </a>';
    }
    if (auth()->user()->can($permission_type . '.edit')) {
        $button .= ' <a href="' . route($route_type . '.edit', $data->id) . '" class="btn btn-icon btn-primary btn-sm"  data-toggle="tooltip" title="Edit">
        ' . SVGI('bi-pencil-square') . '
        </a>';
    }
    if (auth()->user()->can($permission_type . '.delete')) {
        $button .= ' <button class="btn btn-icon btn-sm btn-delete btn-danger" data-remote="' . route($route_type . '.destroy', $data->id) . '" data-toggle="tooltip" title="Delete">
        ' . SVGI('bi-trash') . '
        </button>';
    }

    return $button;
}

function CreateButton($route, $permission_type)
{
    $button = '';
    // dd($permission_type);
    if (auth()->user()->can($permission_type . '.create')) {
        $button = '<div class="dt-action-buttons text-right">
            <div class="dt-buttons">
                <a href="' . route($route . '.create') . '" class="dt-button create-new btn btn-primary">
                    <i data-feather="plus"></i>
                    Add New Record
                </a>
            </div>
        </div>';
    }
    echo $button;
}

function BackButton($route = false, $submit = false, $back = true)
{
    $button = '<div class="dt-action-buttons text-right">
            <div class="dt-buttons">';
    if ($submit) {
        # code...
        $button .= '<button class="btn btn-primary data-submit mr-1">Submit</button>';
    }
    if ($back) {
        # code...
        // $button .= '<a href="' . route($route . '.index')  . '" class="dt-button btn btn-primary btn-warning">
        //                 <i data-feather="chevrons-left"></i>
        //                 Back
        //             </a>';
        $button .= '<button onclick="history.back()" class="dt-button create-new btn btn-warning">
                        <i data-feather="chevrons-left"></i>
                        Back
                    </button>';
    }

    $button .=  '</div>
        </div>';
    echo $button;
}

//function SAVE Permission
function savePermission($argv)
{
    // dd($argv);
    if ($argv[0] == 'make:controller') {
        $type = explode('\\', $argv[1]);
        $type = end($type);
        $type = str_replace('Master', '', $type);
        $type = str_replace('Controller', '', $type);
        $type = Str::of($type)->kebab();
        $type = Str::lower($type);
        // dd($type);
        if (isset($argv[2])) {
            // if($argv[2] == '-r'){
            $permissions = [
                $type . '.index',
                $type . '.create',
                $type . '.edit',
                $type . '.delete',
            ];
            foreach ($permissions as $permission) {
                Permission::findOrCreate($permission);
            }
            // default role
            $role = Role::where('name', 'super-admin')->first();

            // sync permissions to role
            $role->syncPermissions(Permission::all());
            // }
        }
    }
}

// function membuat nested array 
function makeNested($source)
{
    $nested = array();

    foreach ($source as &$s) {
        if (is_null($s['parent_id'])) {
            $nested[] = &$s;
        } else {
            $pid = $s['parent_id'];
            if (isset($source[$pid])) {

                if (!isset($source[$pid]['submenu'])) {
                    $source[$pid]['submenu'] = array();
                }

                $source[$pid]['submenu'][] = &$s;
            }
        }
    }
    return $nested;
}

// fungsi membuat avatar 
function get_avatar($str)
{
    $acronym    = '';
    $word       = '';
    $words      = preg_split("/(\s|\-|\.)/", $str);
    foreach ($words as $w) {
        $acronym .= substr($w, 0, 1);
    }
    $word = $word . $acronym;
    return $word;
}

function topThree($item, $merchant)
{
    // dd($item);
    $html = '';
    if ($item->seq == '1') {
        $position   = '1st';
        $class      = 'bg-light-success';
    }
    if ($item->seq == '2') {
        $position   = '2nd';
        $class      = 'bg-light-warning';
    }
    if ($item->seq == '3') {
        $position   = '3rd';
        $class      = 'bg-light-danger';
    }
    if ($merchant == 'MERCHANT') {
        $svg = 'bi-cart3';
    } else {
        $svg = 'bi-cash-stack';
    }

    if ($item->groups == $merchant) {
        $html = '<div class="col-4">
            <div class="media">
                <div class="avatar ' . $class . ' mr-2">
                    <div class="avatar-content">
                        ' . SVGI($svg) . '
                    </div>
                </div>
                <div class="media-body my-auto">
                    <p class="card-text font-small-3 mb-0">' . $position . ' ' . ucfirst(strtolower($merchant)) . ' </p>
                    <h4 data-toggle="tooltip" data-original-title="Total Amount Rp 0" class="font-weight-bolder mb-0">
                        ' . $item->totalTransaction . ' TRX</h4>
                    <p class="card-text font-small-3 mb-0">
                        ' . Str::upper($item->detailGroup) . '</p>
                    <br>
                </div>
            </div>
        </div>';
    }
    return $html;
}

function topThreeAmt($item, $merchant)
{
    // dd($item);
    $html = '';
    if ($item->seq == '1') {
        $position   = '1st';
        $class      = 'bg-light-success';
    }
    if ($item->seq == '2') {
        $position   = '2nd';
        $class      = 'bg-light-warning';
    }
    if ($item->seq == '3') {
        $position   = '3rd';
        $class      = 'bg-light-danger';
    }
    if ($merchant == 'MERCHANT') {
        $svg = 'bi-cart3';
    } else {
        $svg = 'bi-cash-stack';
    }

    if ($item->groups == $merchant) {
        $html = '<div class="col-4">
            <div class="media">
                <div class="avatar ' . $class . ' mr-2">
                    <div class="avatar-content">
                        ' . SVGI($svg) . '
                    </div>
                </div>
                <div class="media-body my-auto">
                    <p class="card-text font-small-3 mb-0">' . $position . ' ' . ucfirst(strtolower($merchant)) . ' </p>
                    <h4 data-toggle="tooltip" data-original-title="Total Amount Rp 0" class="font-weight-bolder mb-0">
                       Rp.  ' . number_format($item->totalTransaction) . ' </h4>
                    <p class="card-text font-small-3 mb-0">
                        ' . Str::upper($item->detailGroup) . '</p>
                    <br>
                </div>
            </div>
        </div>';
    }
    return $html;
}

function createdAt($created)
{
    return date('Y-m-d H:i:s', strtotime($created));
}

function componentHasPage($data, $seq, $url_page)
{
    $html = '<div
                class="modal fade text-left"
                id="componentHasPage-' . $seq . '"
                tabindex="-1"
                role="dialog"
                aria-labelledby="myModalLabel20"
                aria-hidden="true"
            >
                <div class="modal-dialog modal-dialog-centered modal-xs" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="componentHasPageLabel-' . $seq . '"></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row">';
    // proses generate url  
    foreach ($data as $key => $value) {
        $templateDetail = $value->page->templateDetail;
        foreach ($templateDetail as $k => $v) {

            // sequence component has page disamakan dengan yg ada di template details 
            // dump($value->sequence, $v->sequence);
            if ($value->sequence == $v->sequence) {
                $url_page   =  'dashboard/' . $v->template_id . '/' .  $v->template->name  . '/' . encrypt($v->sequence);
            }
        }
        $html .= '<div class="col-md-12"><a href="' . url($url_page) . '"  class="btn mb-50 btn-block btn-primary">' . $value->page->description . '</a></div>';
    }
    $html .= '</div>
                        </div>
                    </div>
                </div>
            </div>';
    echo $html;
    //  dd($data);   
}

function componentHasPageURL($data)
{
    $hasPage = '';
    // proses generate url  
    foreach ($data as $key => $value) {
        $templateDetail = $value->page->templateDetail;
        foreach ($templateDetail as $k => $v) {
            // sequence component has page disamakan dengan yg ada di template details 
            if ($value->sequence == $v->sequence) {
                $hasPage   =  'dashboard/' . $v->template_id . '/' .  $v->template->name  . '/' . encrypt($v->sequence);
            }
        }
    }

    return $hasPage;
}

// Convert amount to short number currency
function shortNumber($num)
{
    $shortNumberForm = '';
    $units = ['', 'rb', 'Jt', 'M', 'T'];
    for ($i = 0; $num >= 1000; $i++) {
        $num /= 1000; // $num = $num / 1000
    }
    $shortNumberForm = number_format(round($num, 1), 1, ',', '.') . $units[$i];
    return $shortNumberForm;
}

function isJson($string)
{
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

// LDAP ENCRYPT
function encryptPass($pass)
{
    return encryptLDAP("$pass", "gek123", "iknowwhatyoudidlastnigth");
}

function encryptLDAP($password, $salt, $secret)
{
    try {
        $salt = ($salt == null || strlen(trim($salt)) == 0) ? getRandomSalt() : $salt;
        while (strlen($salt) < 2) {
            $salt .= "A";
        }
        if (strlen($salt) > 2) {
            $salt = substr($salt, 0, 2);
        }
        $bsalt = array_slice(unpack("C*", "\0" . $salt), 1);
        $bpwd = array_slice(unpack("C*", "\0" . $password), 1);
        $digest = array_slice(unpack("C*", "\0" . pack("H*", hash("md5", $salt . $secret))), 1);

        $len = strlen($salt) + (count($digest) * ((count($bpwd) + 16) / 16));
        $i = 0;
        $p = 0;
        $j = 0;
        $result = array();
        for (; $i < count($bsalt); $i++) {
            $result[$i] = $bsalt[$i];
        }
        for (; $i < $len; $i++) {
            if ($p < count($bpwd)) {
                $result[$i] = ($bpwd[$p] ^ $digest[($j % count($digest))]);
            } else {
                $result[$i] = (0 ^ $digest[($j % count($digest))]);
            }
            $j++;
            $p++;
        }
        return base64_encode(implode(array_map("chr", $result)));
    } catch (Exception $e) {
    }
}

function doencrypt($password, $secret)
{
    return encryptLDAP($password, null, $secret);
}

function decryptLDAP($password, $secret)
{
    $decode = array_slice(unpack("c*", "\0" . base64_decode($password)), 1);
    $bsalt = array();
    $bsalt[0] = $decode[0];
    $bsalt[1] = $decode[1];

    $bxorp = array();
    for ($x = 2; $x < count($decode); $x++) {
        $bxorp[$x - 2] = $decode[$x];
    }
    $salt = implode(array_map("chr", $bsalt));
    $digest = array_slice(unpack("c*", "\0" . pack("H*", hash("md5", $salt . $secret))), 1);

    $len = count($digest) * ((count($bxorp) + 15) / 16);
    $j = 0;
    $p = 0;
    for ($i = 0; $i < $len; $i++) {
        if ($p < count($bxorp)) {
            $bxorp[$p] = ($bxorp[$p] ^ $digest[($j % count($digest))]);
        }
        $p++;
        $j++;
    }

    $sDecode = implode(array_map("chr", $bxorp));
    return trim($sDecode);
}

function getRandomSalt()
{
    $pattern = "/^[\w]+$/";
    $rand = chr("0");
    $salt = "";
    for ($i = 0; $i < 2;) {
        $rand = chr((getRandomInt() % 62) . "");
        preg_match($pattern, $rand, $matches);
        if (count($matches) == 0) {
            continue;
        }
        $salt .= $matches[0];
        $i++;
    }
    return $salt;
}

function getRandomInt()
{
    $n = rand(0, 100000);
    return $n;
}

// LDAP DECRYPT

function highlihtDetail($data)
{
    if (!$data) {
        return "<td class='bg-light-danger'>" . $data . "</td>";
    } else {
        return "<td>" . $data . "</td>";
    }
}

function highlihtDetailStatus($data)
{
    if ($data == "1") {
        $return =  '<td class="text-center"><div class="text-success" ><div class="avatar-content"><i data-feather="check-circle"></i></div></div></td>';
    } else {
        $return = '<td  class="text-center"><div class="text-danger" ><div class="avatar-content"><i data-feather="x-circle"></i></div></div></td>';
    }
    return $return;
}
