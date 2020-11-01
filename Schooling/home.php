
<?php
 $pagetitle = "Home Page";
 include "Init.php"; 
 ?>
	
			
	<section class="hero-section set-bg" data-setbg="img/bg.jpg" ">
		<div class="container">
		
			<div class="hero-text text-white"  style = "margin-bottom:20px;">
				
				<h2 style = "font-weight:bold;color:#e5e5e5;margin-top:20px;text-shadow: 1px 1px #000;"  >Get The Best Free Online Courses</h2>
					<a href="#demo" style = "font-weight:500; background:#D82A4E" class="btn btn-danger" data-toggle="collapse">Simple Declaration About This Platform</a>
					<p   id="demo" class = " collapse text-justify lead text-capitalize" style = "margin-left:100px;margin-top:15px;width:1000px; color:#fff; font-size:15px;">WebUni, founded in May 2015, is an Egyption online learning platform aimed at professional adults and students. As of Jan 2020, the platform has more than 50 million students and 57,000 instructors teaching courses in over 65 languages. There have been over 295 million course enrollments, Students and instructors come from 190+ countries and 2/3 of students are located outside of the U.S.</p>
				<?php if(!isset($_SESSION['tname']) && !isset($_SESSION['name'])){ ?>	<a  href = "#tutorname" style = "margin-left:10px;background:#e5e5e5; color:#D82A4E ; font-weight:bold" class="btn">Sign Up For Tutors</a> <?php } ?> 
			</div>
			<div class="row" style = "margin-right:300px; margin-top:30px;">
				<div class="col-lg-10 offset-lg-1">
				<?php if(!isset($_SESSION['name']) && !isset($_SESSION['tname'])) {?>
					
					<form class="form-horizontal col-lg-7" action = "login/sign.php?do=sign_parent" method = "post">
					  
					  <div class="form-group">
						<div class="col-sm-10">
						  <input id = "sign" type="text" class="form-control" pattern = ".{4,}" title = "You should put more than 4 chars"  autocomplete = "off"  style = "background:rgba(0,0,100,0);opacity:0.8;color:#fff;border:5px" name = "user"  required  placeholder="Username">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
						  <input type="password" class="form-control" pattern = ".{6,}" title = "You should put more than 6 chars" autocomplete = "off" style = "background:rgba(0,0,100,0);color:#fff;border:5px"  name = "pass" value = "" id="pwd" required placeholder="Password">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
						  <input type="email" class="form-control"  pattern = ".{6,}" title = "You should put more than 6 chars"  autocomplete = "off" style = "background:rgba(0,0,100,0);color:#fff;border:5px" name = "email" id="pwd" id="email" required placeholder="E_Mail">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
						  <input type="text" name = "full" pattern = ".{6,}" title = "You should put more than 6 chars" autocomplete = "off"  style = "background:rgba(0,0,100,0);color:#fff;border:5px"  class="form-control" value = "" id="pwd" required placeholder="Fullname">
						</div>
					  </div>
					  <div class="form-group">
						
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <button type="submit" style = "color:#ddd;background:rgba(0,0,100,0);border:3px solid #777;border-radius :14px; padding:5px; width:140px" class="btn btn-primary">Sign Up Now</button>
						</div>
					  </div>
					</form>
					
				<?php } ?>
				</div>
			</div>
		</div>
	</section>
	<!-- Hero section end -->


	<!-- categories section -->
	<section class="categories-section spad" style = "padding:50px;">
		<div class="container">
			<div class="section-title">
				<h2 style = "color:#D82A4E;font-weight:bolder" >OUR COURSE’S CATEGORY</h2>
				<p class = "text-justify lead text-capitalize" style = "margin-left:100px;margin-top:15px;width:600pxl; color:#888; font-size:16px;">It’s our course’s category that contains our own courses and videos of some fields with a professional coaches in their own fields. </p>
			</div>
			<?php
			$rowa = aadmin::view_category();
					?>
			<div class="row">
			<?php 
			foreach($rowa as $rows){
				$stmt=$con->prepare("select count(*)  from course join cate on course.catid = cate.id  where course.catid = ?");
				$stmt->execute(array($rows['id']));
				$count = $stmt->fetchColumn();
						?>
				<div class="col-lg-4 col-md-6">
					<div class="categorie-item">
						<div class="ci-thumb set-bg" data-setbg="img/categories/1.jpg"></div>
						<div class="ci-text">
							<?php echo "<h5>" . $rows['name'] . "</h5>" ;
							echo "<p>" . $rows['des'] . "</p>" ;
							?>
							<span><?php echo $count ?> Course</span>
						</div>
				
					</div>
				</div>
				<?php 	} ?>
			</div>
		</div>
	</section>
	<!-- categories section end -->


	<!-- search section -->
		<hr style = "border : 1.5px solid #D82A4E;">
	<section class="course-section spad" style = "padding:20px;margin-bottom:20px;">
		<div class="container">
			<div class="section-title mb-0">
				<h1 style = "font-weight:bold ; font-size:50px;color:#D82A4E;" >ALL COURSES</h1>
				<p class = "text-justify lead text-capitalize" style = "margin-left:100px;margin-top:15px;width:600pxl; color:#888; font-size:16px;">It’s our course’s that we have in all fields you will be happy and lucky for joining our courses in this platform . </p>
			</div>
		</div>
		
		<div class="course-warp">
			<ul class="course-filter controls">
				<li class="control active" data-filter="all">All</li>
				<?php
				$rowa = aadmin::view_category();
				foreach($rowa as $rows){?>
					 <li class="control" data-filter=".<?php echo $rows['name'] ?>"><?php echo $rows['name'] ?></li> 
			<?php 	}
				?>
			</ul>  
						
			<div class="row course-items-area" style = "padding-left:100px;padding-right:100px;">
			<?php $stmt=$con->prepare("select course.* ,tutor.fullname as tname ,tutor.image as image1 , cate.name as cname  from course join tutor on course.tut = tutor.id join cate on course.catid = cate.id ");
				$stmt->execute();
				$row22=$stmt->fetchAll();
				foreach($row22 as $roww){
					if(isset($_SESSION['pid'])){
					$stmt=$con->prepare("select parentid , courseid  from conn where parentid = ? and courseid = ? and approval = 1");
					$stmt->execute(array($_SESSION['pid'] , $roww['id']));
					$count00=$stmt->rowCount();
					
					$stmt1=$con->prepare("select parentid , courseid  from conn where parentid = ? and courseid = ? and approval = 0");
					$stmt1->execute(array($_SESSION['pid'] , $roww['id']));
					$count11=$stmt1->rowCount();
					
					$stm = $con->prepare('select count(*) from conn where conn.courseid = ? and approval = 1');
					$stm->execute(array($roww['id']));
					$count = $stm->fetchColumn();
					}
					?>
				<!-- course -->
				<div class="mix col-lg-4 col-md-4 col-sm-6 <?php echo $roww['cname'];?>">
					<div class="course-item" >
						<div class="course-thumb set-bg" data-setbg="img/courses/<?php echo $roww['image']; ?>">
							<div class="price">Price is : $<?php echo $roww['price'] ?></div>
						</div>
						
						<div class="course-info">
							<div class="course-text">
							 <h5><?php echo $roww['name'] ?></h5>
								<p><?php echo $roww['descr'] ?></p>
								
								<div class="students"><?php echo $count; ?> Students</div>
							</div>
							<div class="course-author" style = "padding:5px;">
							<div style = "margin-left:25px;">
								<div class="ca-pic set-bg" data-setbg="img/authors/<?php echo $roww['image1']; ?>" style = "margin-top:15px;"></div>
								<p>DR : <?php echo $roww['tname'] ?>.<br> <span>Software_Engineer</span></p>
								</div>
								<div style = "padding:5px;" >
								<?php
								if(isset($_SESSION['name'])){
								if(!$count00>0 && !$count11>0){ ?>
								<hr>
								<a href='signcourse.php?do=sign_course&id=<?php echo $roww['id'] ?> ' class="btn btn-danger col-lg-12" style="color:#fff; font-weight:bold" >Enroll now</a>
								<?php
								}
								
								else if(!$count00>0 && $count11>0) {  ?>
								<hr>
								<h1  class="btn col-lg-12" style="color:#fff;background:#000; font-weight:bold ;">Wait For Approval</h1>
								<?php
								}
								
								else if($count00>0) {  ?>
								<hr>
								<h1  class="btn col-lg-12" style="color:#000;background:#fff;border:1.5px solid #000; font-weight:bold ;">You Are Enrolled Before</h1>
								<?php
								}
								}
								else if(isset($_SESSION['tname'])){
									
								}
								else{?>
									<a href = "#sign"  class="btn btn-danger  col-lg-12" style="color:#eee; font-weight:bold ; padding:5px;">You have to login or signup</a>
								<?php }
								?>
							</div>
							</div>
							
						</div>
					</div>
				</div>
				<!-- course -->
				<?php } ?>
			</div>
				
		</div>
		
	</section>
	<!-- course section end -->


	<!-- signup section -->
	<?php if(!isset($_SESSION['name']) && !isset($_SESSION['tname'])){ ?>
	<section class="signup-section spad" >
		<div class="signup-bg set-bg" data-setbg="img/signup-bg.jpg"></div>
		<div class="container-fluid">
			<div class="row">
				<div class="col-lg-6">
					<div class="signup-warp" >
					<div class="section-title text-white text-left"  style = "margin-bottom:30px">
							<h2 style = "font-weight:700;font-style:italic;text-shadow:2px 2px 2px #840505">Sign up to became a tutor</h2>
							<p class = "text-justify lead text-capitalize" style = "font-size:15px;">Hello..!! it is aform form tutors that for who wants to apply for teaching and adding courses in this platform.</p>
					</div>
					<div style = "background:#fff;padding:42px;height:500px;border-radius:10px;">
					<form class="form-horizontal " action = "login/sign.php?do=sign_tutor" method = "post" enctype = "multipart/form-data">
					  
					  <div class="form-group" >
						<div class="col-sm-10">
						  <input  style = "background:#EDF4F6;padding:15px;width:350px;border:2px solid #EDF4F6" pattern = ".{4,}" title = "You should put more than 4 chars" id = "tutorname" type = "text" name = "user"  autocomplete = "off"  required placeholder = "Your Username" ?>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
						  <input  style = "background:#EDF4F6;padding:15px;width:350px;border:2px solid #EDF4F6" pattern = ".{6,}" title = "You should put more than 6 chars" type = "password"  name = "pass"    autocomplete = "off" required placeholder = "Your password">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
						  <input style = "background:#EDF4F6;padding:15px;width:350px;border:2px solid #EDF4F6" pattern = ".{6,}" title = "You should put more than 6 chars" type = "email" name = "email"  required placeholder = "Your E_Mail" autocomplete = "off">
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
							<input  style = "background:#EDF4F6;padding:40px;padding-top:15px;padding-left:15px;width:350px;border:2px solid #EDF4F6" pattern = ".{6,}" title = "You should put more than 6 chars"  class = "form-control" type = "file" name="img0" required>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-10">
							
							<input style = "background:#EDF4F6;padding:15px;width:350px;border:2px solid #EDF4F6" type = "text" name = "full"  required placeholder = "Your Full Name" autocomplete = "off">
					  </div>
					  </div>
					  <div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
						  <button  style = "background:#D82A4E;padding:10px;border:2px solid #D82A4E;width:150px;color:#EDF4F6;font-weight:700" >Register</button>
						</div>
					  </div>
					</form>
					</div>
						
				</div>
			</div>
		</div>
	</section>
	
	<?php  } ?>
	<!-- signup section end -->


	


	<!-- footer section -->
	<footer class="footer-section spad pb-0">
		<div class="footer-top">
			<div class="footer-warp">
				<div class="row">
					<div class="widget-item">
						<h4>Contact Info</h4>
						<ul class="contact-list">
							<li>13 Selim Lane <br>Giza , Cairo 2001</li>
							<li>+20 01157135820</li>
							<li>yaseenyoussef@gmail.com</li>
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
Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://www.facebook.com/profile.php?id=100026114898119" target="_blank">Yusuf_yaseen</a>
<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. --></div>
			</div>
		</div>
	</footer> 
	<!-- footer section end -->


	<!--====== Javascripts & Jquery ======-->
		<?php
 include $tpl . "Footer.php" 
 ?>