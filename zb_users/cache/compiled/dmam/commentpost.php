<?php  /* Template Name:发布评论 */  ?>

<div id="dm-comment-titlebar" class="am-titlebar am-titlebar-multi">
  <div class="am-titlebar-title am-icon-pencil-square-o"> 发表评论</div>
</div>
<div id="comment-post" class="cmt-post">
<?php 
	$cavatar = '';
	$cname = '';
	if ($zbp->CheckPlugin('ggravatar')){
		if (isset($_COOKIE['email'])){
			$cavatar = ggravatar_get( $email=$_COOKIE['email'], $s = null, $d = null, $r = null, $img = false, $atts = array() );
		}else{
			$cavatar = ggravatar_get( $email=null, $s = null, $d = null, $r = null, $img = false, $atts = array() );
		}
	}
	if (isset($_COOKIE['name'])){
		$cname = dmam_unescape($_COOKIE['name']);
	}else{
		$cname = '访客';
	}
 ?>
<?php if ($user->ID>0) { ?>
<div class="cmt-post-avatar"><img class="am-comment-avatar" src="<?php  echo $user->Avatar;  ?>" alt="<?php  echo $user->StaticName;  ?>的头像"></div>
<?php }else{  ?>
<div class="cmt-post-avatar"><img class="am-comment-avatar" src="<?php  echo $cavatar;  ?>" alt="<?php  echo $cname;  ?>的头像"></div>
<?php } ?>
  <form id="cmt-post-form" class="am-form am-g" target="_self" method="post" action="<?php  echo $article->CommentPostUrl;  ?>">
	<input type="hidden" name="inpId" id="inpId" value="<?php  echo $article->ID;  ?>" />
	<input type="hidden" name="inpRevID" id="inpRevID" value="0" />
<?php if ($user->ID>0) { ?>
	<input type="hidden" name="inpName" id="inpName" value="<?php  echo $user->Name;  ?>" />
	<input type="hidden" name="inpEmail" id="inpEmail" value="<?php  echo $user->Email;  ?>" />
	<input type="hidden" name="inpHomePage" id="inpHomePage" value="<?php  echo $user->HomePage;  ?>" />	
<?php }else{  ?>
 <div class="am-form-group am-u-md-6 am-u-sm-12">
        <input placeholder="名称" type="text" id="inpName" name="inpName" size="28" tabindex="1" required value="<?php  echo $user->Name;  ?>" />
 </div>
 <div class="am-form-group am-u-md-6 am-u-sm-12">
        <input placeholder="邮箱" type="text" id="inpEmail" name="inpEmail" size="28" tabindex="2" value="<?php  echo $user->Email;  ?>" />
        
 </div>
 <div class="am-form-group am-u-md-6 am-u-sm-12">
        <input placeholder="网址" type="text" id="inpHomePage" name="inpHomePage" size="28" tabindex="3" value="<?php  echo $user->HomePage;  ?>" />
        
 </div>

	<?php if ($option['ZC_COMMENT_VERIFY_ENABLE']) { ?>
	 <div class="am-form-group am-u-md-6 am-u-sm-12">
			<input placeholder="验证码" type="text" name="inpVerify" id="inpVerify" class="text" value="" size="28" tabindex="4" />
	<img style="width:<?php  echo $option['ZC_VERIFYCODE_WIDTH'];  ?>px;height:<?php  echo $option['ZC_VERIFYCODE_HEIGHT'];  ?>px;cursor:pointer;" src="<?php  echo $article->ValidCodeUrl;  ?>" alt="" title="" onclick="javascript:this.src='<?php  echo $article->ValidCodeUrl;  ?>&amp;tm='+Math.random();"/>
			
	 </div>
	<?php } ?>

<?php } ?>

 <div class="am-form-group am-u-md-12">
      <textarea name="txaArticle" id="txaArticle" class="txt" rows="5" tabindex="5" required></textarea>
 </div>
    <p class="am-u-md-12">
      <button class="am-btn am-btn-default" name="sumbit" type="submit" tabindex="6" onclick="return zbp.comment.post()">提交</button>
    </p>
  </form>
</div>