
<?php
 $pagetitle = "Tutor Page";
 include "Init.php"; 
 if(isset($_SESSION['tname'])){
 ?>

	<!-- Page info -->
	<div class="page-info-section set-bg" data-setbg="img/page-bg/5.jpg">
		<div class="container">
			<div class="site-breadcrumb">
			<div style = "margin-bottom:25px;">
				<a href = "#tutorname" style = "color:#D82A4E;">Edit your account</a>
				<a href="home.php">Home</a>
				<span >Elements</span>
				</div>
				<div class="container" style = "margin-top:5px;">
				<h2 class = "text-capitalize" style = "margin-left:189px; color:#e5e5e5; font-weight:bold; font-size:48px;text-shadow: 2px 1px #000;" >You Can Add Your Own Courses</h2>
					<div style = "margin-top:13px;">
				
				<button href="#demo" class="btn btn-danger" data-toggle="collapse" style = "margin-left:450px;background:#D82A4E;color:#e5e5e5; font-weight:700;font-size:17px" >Simple Description</button>
				   
				  <p id="demo" class="collapse text-justify lead text-capitalize" style = "width:800px;margin-left:200px;margin-top:5px;color:#ccc;font-size:15px;">
					Hi Dr : <?php echo $_SESSION['tname'] ?> it is your own page where you can add , delete and update your own courses.
				 </p>
				</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Page info end -->

	
	<!-- search section -->
	<section class="search-section ss-other-page" style = "margin-left:200px;">
		
	</section>
	<!-- search section end -->


	<!-- Page -->
	<section class="elements-page spad pb-0" style = "padding:80px;margin-top:65px;">
		<div class="container">
		
			<div class="element">
				<h2 class="e-title text-capitalize" style = "margin-left:270px;margin-bottom:16px;font-size:50px; font-weight:750;text-shadow:1px 1px 1px #720101; color:#D82A4E">Your Course’s Dr : <?php echo $_SESSION['tname'] ?></h2>
			</div>
					
					
	  <section class="course-section spad" style = "padding:23px;margin-bottom:20px;">
		<div class="container">
			<div class="section-title mb-0">
			</div>
		</div>
		
		<div class="course-warp" >	
			<div class="row course-items-area">
			<?php 
			$row2 = tutor::select_courses($_SESSION['tid']);
			
				foreach($row2 as $roww){
					
					$stmt=$con->prepare("select * from book where cid = ? and approval = 1");
					$stmt->execute(array($roww['id']));
					$book = $stmt->fetch();
					$bcount = $stmt->rowCount();
					
					$stmt=$con->prepare("select * from book where cid = ? and approval = 0");
					$stmt->execute(array($roww['id']));
					$book1 = $stmt->fetch();
					$bcount1 = $stmt->rowCount();
					
					$stm = $con->prepare('select count(*) from conn where conn.courseid = ?');
					$stm->execute(array($roww['id']));
					$count = $stm->fetchColumn();
					?>
				<!-- course -->
				<div class="mix col-lg-4 col-md-4 col-sm-6">
					<div class="course-item">
						<div class="course-thumb set-bg"  data-setbg="img/courses/<?php echo $roww['image']; ?>">
						<?php
								if($roww['approval']==1) { ?>
									<button class="btn" style = "color:#fff;background:#D82A4E;width:100%;border-radius:0px;font-size:20px;font-weight:700">Approved</button>
								<?php	}
								else {?>
									<button class="btn" style = "color:#fff;background:#000;width:100%;border-radius:0px;font-size:20px;font-weight:700">Not Approved</button>
							<?php } ?>
							<br>
							<div class="price">Price is : $<span style = "font-weight:bold;font-size:17px;font-style:italic;color:#fff" ><?php echo $roww['price'] ?></span></div>
						</div>
						
						<div class="course-info">
							<div class="course-text">
							 <h5 style = "font-weight:bold;font-style:italic;font-size:28px; color:#D82A4E"><?php echo $roww['cname'] ?></h5>
							 <h5><?php echo $roww['name'] ?></h5>
								<p><?php echo $roww['descr'] ?></p>
								
								<div class="students"><?php echo $count; ?> Students</div>
								<?php 
								if(!$bcount>0 && !$bcount1>0){ ?>
									<h6 style = "color:#000;font-style:italic;margin-top:3px;">No Books Here Please <a href = "manage.php?do=add_book&courseid=<?php echo $roww['id'] ?>" style = "font-weight:bold ; font-style:italic ;color:#a50303">Add Book</a></h6>
								
								<?php }
								else if(!$bcount>0 && $bcount1>0){ ?>
									<h6 style = "color:#000;font-style:italic;font-weight:700;margin-top:3px;color:#840303">Please Wait For Approving The Book</h6>
								<?php }
								
								  else if($bcount>0){ ?>
										<h6 style = "font-size:17px;font-weight: bold;font-style:italic;margin-top:3px;">Book : <a style = "color:#D82A4E" href = "<?php echo $book['link']; ?>"><?php echo $book['name']; ?></a></h6>
								<?php }
							?>
							</div>
							<div class="course-author" style = "padding:5px;">
							<div style = "margin-left:25px;">
								<div class="ca-pic set-bg" data-setbg="img/authors/<?php echo $roww['image1']; ?>" style = "margin-top:15px;"></div>
								<p>DR : <?php echo $roww['tname'] ?>. <span>Software_Engineer</span></p>
								</div>
								<hr>
								<div style = "padding:5px;" >
								<a  href = "manage.php?do=edit&courseid=<?php echo $roww['id'] ?>" class='btn ' style = "width:48%; border : 0.4px solid #D82A4E; background:#D82A4E; color:#f4f4f4 ;font-weight:600; font-size:17px;"> <i class = 'fa fa-edit'></i>Edit</a>
								<a  href = "manage.php?do=delete&courseid=<?php echo $roww['id'] ?>" class='btn ' style = "width:50%; border : 0.4px solid #000; background:#000; color:#fff ;font-weight:600; font-size:17px;" ><i class = 'fa fa-close'></i>Delete</a>
							</div>
							</div>
							
						</div>
					</div>
				</div>
				<!-- course -->
				<?php } ?>
			</div>
				<a href = "manage.php?do=add" class = "btn" style = "width:100%;font-weight:bold;font-size:17px;background:#D82A4E;color:#FFF;" >Add Course</a>
		</div>
		<hr style = "margin-bottom:10px;margin-top:65px;border:1px solid #D82A4E;width:100%;">
	</section>
					
			<div class="element">
				<h2 class="e-title">Loaders</h2>
				<div class="row">
					<div class="col-lg-3 col-sm-6 cp-item">
						<div class="circle-progress" data-cpid="id-1" data-cpvalue="98" data-cpcolor="#e82154" data-cptitle="New Students"></div>
					</div>
					<div class="col-lg-3 col-sm-6 cp-item">
						<div class="circle-progress" data-cpid="id-2" data-cpvalue="83" data-cpcolor="#e82154" data-cptitle="New Teachers"></div>
					</div>
					<div class="col-lg-3 col-sm-6 cp-item">
						<div class="circle-progress" data-cpid="id-3" data-cpvalue="25" data-cpcolor="#e82154" data-cptitle="Creativity"></div>
					</div>
					<div class="col-lg-3 col-sm-6 cp-item">
						<div class="circle-progress" data-cpid="id-4" data-cpvalue="95" data-cpcolor="#e82154" data-cptitle="Prestige"></div>
					</div>
				</div>
			</div>
			<!-- Element -->
			<div class="element">
				<h2 class="e-title">Milestones</h2>
				<div class="row">
					<div class="col-lg-3 col-sm-6 fact-item">
						<h2>1200</h2>
						<p>New Students</p>
					</div>
					<div class="col-lg-3 col-sm-6 fact-item">
						<h2>15k</h2>
						<p>Grad Students</p>
					</div>
					<div class="col-lg-3 col-sm-6 fact-item">
						<h2>234</h2>
						<p>Qualified Teachers</p>
					</div>
					<div class="col-lg-3 col-sm-6 fact-item">
						<h2>3792</h2>
						<p>Amazing Courses</p>
					</div>
				</div>
			</div>
			<!-- Element -->
			<h2 style = "margin-bottom:20px;" >Edititng</h2>
			<section class="signup-section spad" >
		<div class="signup-bg set-bg" data-setbg="img/signup-bg.jpg"></div>
		<div class="container-fluid">
			<div class="row">
			
				
						<!--<form class="signup-form" action = "login/sign.php?do=edit_tutor" method = "post">-->
				<?php
				$stmt = $con->prepare("SELECT *  from tutor where id = ?  ");
				$stmt->execute(array($_SESSION['tid']));
				$row = $stmt->fetch();
				?>
				<div class="col-lg-6">
					<div class="signup-warp" style = "padding-left:20px;" >
					<div class="section-title text-white text-left"  style = "margin-bottom:30px">
							<h2 style = "font-weight:700;font-style:italic;text-shadow:2px 2px 2px #840505">Edit Your Profile</h2>
							<p class = "text-justify lead text-capitalize" style = "font-size:15px;">Hello..!! it is a form form tutors that for who wants to apply for teaching and adding courses in this platform.</p>
					</div>
					<div style = "background:#fff;padding:42px;padding-left:23px;height:500px;border-radius:10px;width:460px;">
					<form class="form-horizontal" action = "login/sign.php?do=edit_tutor" method = "post" enctype = "multipart/form-data">
					  <input type = "hidden" name = "oldpass" value = "<?php echo $row['password'] ?>">
					  <input type = "hidden" name = 'g' value = "<?php echo $row['image'] ?>">
					  <div class="form-group" >
						<div class="col-sm-10">
						  <input  style = "background:#EDF4F6;padding:15px;width:390px;border:2px solid #EDF4F6" value = <?php echo $row['username']; ?> pattern = ".{4,}" title = "You should put more than 4 chars" id = "tutorname" type = "text" name = "user"  autocomplete = "off"   placeholder = "Your Username" ?>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
						  <input  style = "background:#EDF4F6;padding:15px;width:390px;border:2px solid #EDF4F6"   type = "password"  name = "newpass"    autocomplete = "off"  placeholder = "Your password">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
						  <input style = "background:#EDF4F6;padding:15px;width:390px;border:2px solid #EDF4F6"  value = <?php echo $row['email']; ?> pattern = ".{6,}" title = "You should put more than 6 chars" type = "email" name = "email"   placeholder = "Your E_Mail" autocomplete = "off">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
							<input  style = "background:#EDF4F6;padding:40px;padding-top:15px;padding-left:15px;width:390px;border:2px solid #EDF4F6" pattern = ".{6,}" title = "You should put more than 6 chars"  class = "form-control" type = "file" name="imgagge" >
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
							
							<input style = "background:#EDF4F6;padding:15px;width:390px;border:2px solid #EDF4F6" type = "text" name = "full"   value = <?php echo $row['fullname']; ?>  placeholder = "Your Full Name" autocomplete = "off">
					  </div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <input type = "submit" value = "Edit" style = "background:#D82A4E;padding:10px;border:2px solid #D82A4E;width:120px;color:#EDF4F6;font-weight:700">
						</div>
					  </div>
					</form>
					</div>
						
				</div>
			</div>
		</div>
	</section>
		</div>
	</section>
	<!-- Page end -->


	<!-- footer section -->
	<footer class="footer-section spad pb-0">
		<div class="footer-top">
			<div class="footer-warp">
				<div class="row">
					<div class="widget-item">
						<h4>Contact Info</h4>
						<ul class="contact-list">
							<li>1481 Creekside Lane <br>Avila Beach, CA 931</li>
							<li>+53 345 7953 32453</li>
							<li>yourmail@gmail.com</li>
						</ul>
					</div>
					<div class="widget-item">
						<h4>Engeneering</h4>
						<ul>
							<li><a href="">Applied Studies</a></li>
							<li><a href="">Computer Engeneering</a></li>
							<li><a href="">Software Engeneering</a></li>
							<li><a href="">Informational Engeneering</a></li>
							<li><a href="">System Engeneering</a></li>
						</ul>
					</div>
					<div class="widget-item">
						<h4>Graphic Design</h4>
						<ul>
							<li><a href="">Applied Studies</a></li>
							<li><a href="">Computer Engeneering</a></li>
							<li><a href="">Software Engeneering</a></li>
							<li><a href="">Informational Engeneering</a></li>
							<li><a href="">System Engeneering</a></li>
						</ul>
					</div>
					<div class="widget-item">
						<h4>Development</h4>
						<ul>
							<li><a href="">Applied Studies</a></li>
							<li><a href="">Computer Engeneering</a></li>
							<li><a href="">Software Engeneering</a></li>
							<li><a href="">Informational Engeneering</a></li>
							<li><a href="">System Engeneering</a></li>
						</ul>
					</div>
					<div class="widget-item">
						<h4>Newsletter</h4>
						<form class="footer-newslatter">
							<input type="email" placeholder="E-mail">
							<button class="site-btn">Subscribe</button>
							<p>*We don’t spam</p>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="footer-bottom">
			<div class="footer-warp">
				<ul class="footer-menu">
					<li><a href="#">Terms & Conditions</a></li>
					<li><a href="#">Register</a></li>
					<li><a href="#">Privacy</a></li>
				</ul>
				<div class="copyright"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
			</div>
		</div>
	</footer> 
	<!-- footer section end -->


	<!--====== Javascripts & Jquery ======-->
	<?php
 include $tpl . "Footer.php";
 }
 else{
 echo "<div class = 'content'>";
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
			echo "</div>";
 }
 ?>
