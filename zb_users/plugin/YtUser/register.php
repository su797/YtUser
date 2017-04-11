<?php

require '../../../zb_system/function/c_system_base.php';

$zbp->Load();

Add_Filter_Plugin('Filter_Plugin_Zbp_ShowError','RespondError',PLUGIN_EXITSIGNAL_RETURN);

if (!$zbp->CheckPlugin('YtUser')) {$zbp->ShowError(48);die();}

$name=trim($_POST['name']);
$password=trim($_POST['password']);
$repassword=trim($_POST['repassword']);
$member->Email='null@null.com';
if (isset($_POST["homepage"])) {
    $homepage=trim($_POST['homepage']);
}else{
    $homepage=$zbp->host;
}
$verifycode=trim($_POST['verifycode']);

if(!$zbp->CheckValidCode($verifycode,'register')){
	$zbp->ShowError('验证码错误，请重新输入.');die();
}
$guid=GetGuid();
$member=new Member;
$member->Guid=$guid;
$member->Level=5;
if(strlen($name)<$zbp->option['ZC_USERNAME_MIN']||strlen($name)>$zbp->option['ZC_USERNAME_MAX']){
	$zbp->ShowError('用户名不能过长或过短.');die();
}

if(!CheckRegExp($name,'[username]')){
	$zbp->ShowError('用户名只能包含字母数字._和中文.');die();
}

if(isset($zbp->membersbyname[$name])){
	$zbp->ShowError('用户名已存在');die();
}

$member->Name=$name;

if(strlen($password)<$zbp->option['ZC_PASSWORD_MIN']||strlen($password)>$zbp->option['ZC_PASSWORD_MAX']){
	$zbp->ShowError('密码必须在'.$zbp->option['ZC_PASSWORD_MIN'].'位-'.$zbp->option['ZC_PASSWORD_MAX'].'位间.');die();
}

if($password!=$repassword){
	$zbp->ShowError('请核对密码.');die();
}


$member->Password=Member::GetPassWordByGuid($password,$guid);

$member->PostTime=time();

$member->IP=GetGuestIP();

if(strlen($homepage)>$zbp->option['ZC_HOMEPAGE_MAX']){
	$zbp->ShowError('网址不能过长.');die();
}

if(CheckRegExp($homepage,'[homepage]')){
	$member->HomePage=$homepage;
}

$member->Save();

$YtdsSlide_Table='%pre%ytuser';
$DataArr = array(
    'tc_uid' => $member->ID,
    'tc_oid' => "000000",
);
$sql= $zbp->db->sql->Insert($YtdsSlide_Table,$DataArr);
$zbp->db->Insert($sql);
echo '恭喜您注册成功,请在登录页面登录.';
?>