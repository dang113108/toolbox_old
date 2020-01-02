<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="js/firebaseInit.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.min.js" integrity="sha256-MZo5XY1Ah7Z2Aui4/alkfeiq3CopMdV/bbkc/Sh41+s=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.min.js" integrity="sha256-oSgtFCCmHWRPQ/JmR4OoZ3Xke1Pw4v50uh6pLcu+fIc=" crossorigin="anonymous"></script>
<link rel="stylesheet" type="text/css" href="css/slideTab.css">
<script type="text/javascript" src="js/slideTab.js"></script>
<div id="mwt_mwt_slider_scroll">
	<div id="messagePin" class="messagePinBtn"><i class="fas fa-thumbtack"></i></div>
	<div id="mwt_fb_tab">
		<div class="messageNotifyDiv" id="messageNotifyDiv">
			<span class="messageNotifyCount" id="messageNotifyCount">0</span>
			<span></span>
		</div>
		<span>個</span>
		<span></span>
		<span>人</span>
		<span></span>
		<span>工</span>
		<span></span>
		<span>具</span>
		<span></span>
		<span>箱</span>
	</div>
	<div id="mwt_slider_content">
		<div>
			<ul class="nav nav-pills mb-3 justify-content-center slideHeader" id="pills-tab" role="tablist">
				<li class="nav-item">
					<a class="nav-link active" id="pills-achi-tab" data-toggle="pill" href="#pills-achi" role="tab" aria-controls="pills-achi" aria-selected="true">成就</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="false">發案</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">接案</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-contact" role="tab" aria-controls="pills-contact" aria-selected="false">收藏</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" id="pills-contact-tab" data-toggle="pill" href="#pills-message" role="tab" aria-controls="pills-message" aria-selected="false">訊息<span class="messageNotifyBtn" id="messageNotifyBtn"></span></a>
				</li>
			</ul>
		</div>
		<div id="slideBody" class="slideBody">
			<div class="tab-content" id="pills-tabContent">
				<div class="tab-pane fade show active" id="pills-achi" role="tabpanel" aria-labelledby="pills-achi-tab">
					<ul class="nav nav-tabs justify-content-center" id="achiUl" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="achi-post-tab" data-toggle="tab" href="#achi-post" role="tab" aria-controls="achi-post" aria-selected="true">發案方</a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="achi-get-tab" data-toggle="tab" href="#achi-get" role="tab" aria-controls="achi-get" aria-selected="false">接案方</a>
						</li>
					</ul>

					<!-- Tab panes -->
					<div class="tab-content">
						<div class="tab-pane active" id="achi-post" role="tabpanel" aria-labelledby="achi-post-tab">
							<div id="slidePostRatyChart">
								<canvas id="postCanvas"></canvas>
								<div class="slideRatyTextDiv"><span id="slideRatyLeftSpanPost" class="slideRatyLeftSpan">0</span><span>/5</span></div>
							</div>
							<div id="slidePostRatyCategory" class="slideRatyCategory">
								<img class="slideRatyImg" src="icon-color/00.png" alt="全部" onclick="showSlideRatyPost('');">
								<img class="slideRatyImg" src="icon-color/01.png" alt="日常" onclick="showSlideRatyPost('日常');">
								<img class="slideRatyImg" src="icon-color/02.png" alt="外送" onclick="showSlideRatyPost('外送');">
								<img class="slideRatyImg" src="icon-color/03.png" alt="修繕" onclick="showSlideRatyPost('修繕');">
								<img class="slideRatyImg" src="icon-color/04.png" alt="除蟲" onclick="showSlideRatyPost('除蟲');">
								<img class="slideRatyImg" src="icon-color/05.png" alt="接送" onclick="showSlideRatyPost('接送');">
								<img class="slideRatyImg" src="icon-color/06.png" alt="課業" onclick="showSlideRatyPost('課業');">
							</div>
							<div id="slidePostRatyList" class="slideRatyList">
							</div>
						</div>
						<div class="tab-pane" id="achi-get" role="tabpanel" aria-labelledby="achi-get-tab">
							<div id="slideGetRatyChart">
								<canvas id="getCanvas"></canvas>
								<div class="slideRatyTextDiv"><span id="slideRatyLeftSpanGet" class="slideRatyLeftSpan">0</span><span>/5</span></div>
							</div>
							<div id="slideGetRatyCategory" class="slideRatyCategory">
								<img class="slideRatyImg" src="icon-color/00.png" alt="全部" onclick="showSlideRatyGet('');">
								<img class="slideRatyImg" src="icon-color/01.png" alt="日常" onclick="showSlideRatyGet('日常');">
								<img class="slideRatyImg" src="icon-color/02.png" alt="外送" onclick="showSlideRatyGet('外送');">
								<img class="slideRatyImg" src="icon-color/03.png" alt="修繕" onclick="showSlideRatyGet('修繕');">
								<img class="slideRatyImg" src="icon-color/04.png" alt="除蟲" onclick="showSlideRatyGet('除蟲');">
								<img class="slideRatyImg" src="icon-color/05.png" alt="接送" onclick="showSlideRatyGet('接送');">
								<img class="slideRatyImg" src="icon-color/06.png" alt="課業" onclick="showSlideRatyGet('課業');">
							</div>
							<div id="slideGetRatyList" class="slideRatyList">
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane fade" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
					<?php include "ajax/ajaxSlidePost.php"; ?>
				</div>
				<div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
					<?php include "ajax/ajaxSlideGet.php"; ?>
				</div>
				<div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
					<?php include "ajax/ajaxSlideCollect.php"; ?>
				</div>
				<div class="tab-pane fade" id="pills-message" role="tabpanel" aria-labelledby="pills-contact-tab">
					<?php include "ajax/ajaxSlideMessageList.php"; ?>
					<div class="zindex9999" id="slideMessageFirebase">
						<div id="slideMessageHeader" class="slideMessageHeader">
							<button id="backSlideMessage" type="button" class="zindex9999 close sameline">
								<i class="fas fa-arrow-left"></i>
								<div style="clear: both;"></div>
							</button>
							<div id="slideMessageTitle" class="slideMessageTitle"></div>
							<div style="clear: both;"></div>
						</div>
						<div id="slideMessageBody" class="slideMessageBody">
						</div>
						<div id="slideMessageFloot" class="input-group mb-3 slideMessageFloot">
							<input id="sendMessageText" type="text" class="form-control" placeholder="傳送訊息…" aria-label="Recipient's username" aria-describedby="basic-addon2">
							<div class="input-group-append">
								<label class="btn btn-outline-secondary unsetLabel">圖片<input class="hideFileUpload" id="sendImgBtn" type="file" name="sendImgBtn" accept="image/*"></label>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- bigImage modal -->
<div id="bigImgModal" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div id="bigImgModalDiv" class="modal-dialog modal-dialog-centered">
	</div>
</div>