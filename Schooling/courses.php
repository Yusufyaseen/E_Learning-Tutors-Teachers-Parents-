
<?php
 $pagetitle = "Courses";
 include "Init.php"; 
 if(isset($_SESSION['name'])){
 ?>
	<div class="page-info-section set-bg" data-setbg="img/page-bg/1.jpg">
		<div class="container">
		   <div class="site-breadcrumb"> 
				<a href="home.php">Home</a>
				<span>Courses</span>
			</div>

			<div class = "row" style = "margin-left:130px;margin-top:40px;">
				<h1 class = "text-capitalize" style = "margin-left:30px;color:#e5e5e5; font-weight:bold; font-size:80px;text-shadow: 2px 1px #000;" >It Is Your Own Courses</h1>
				<hr style = "background:#fff;">
			</div>
			<hr>
		</div>
	</div>
	<!-- Page info end -->


	<!-- search section -->

	<!-- search section end -->


	<!-- course section -->
	<section class="course-section spad pb-0" style = "padding:10px;">
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
			<div class="row course-items-area">
				<!-- course -->
				
				<?php
				$stmt=$con->prepare("select * from conn where parentid = ? and approval = 1");
				$stmt->execute(array($_SESSION['pid']));
				$row2=$stmt->fetchAll();
				if(!empty($row2)){
				foreach($row2 as $row0){
					$stmt=$con->prepare("select course.* ,tutor.fullname as tname ,tutor.image as image1, cate.name as cname  from course join tutor on course.tut = tutor.id join cate on course.catid = cate.id where course.id = ?");
					$stmt->execute(array($row0['courseid']));
					$roww=$stmt->fetch();
				
					$stmt=$con->prepare("select * from book where cid = ? and approval = 1");
					$stmt->execute(array($roww['id']));
					$book = $stmt->fetch();
					$bcount = $stmt->rowCount();
					
					$stm = $con->prepare('select count(*) from conn where conn.courseid = ?');
					$stm->execute(array($roww['id']));
					$count = $stm->fetchColumn();
					?>
				<!-- course -->
				<div class="mix col-lg-3 col-md-4 col-sm-6 <?php echo $roww['cname']?>">
					<div class="course-item">
						<div class="course-thumb set-bg" data-setbg="img/courses/5.jpg">
							<div class="price">Price is : $<?php echo $roww['price'] ?></div>
						</div>
						
						<div class="course-info">
							<div class="course-text">
							 <h5><?php echo $roww['name'] ?></h5>
								<p><?php echo $roww['descr'] ?></p>
								
								<div class="students"><?php echo $count;?> Students</div> <?php 
									if($bcount > 0){
								?>
								<p style = "font-size:17px;font-weight: bold;font-style:italic">Book Of Course: <a style = "color:#D82A4E" href = "<?php echo $book['link']; ?>"><?php echo $book['name']; ?></a></p>
						
									<?php } 
										else{
									?>
									<p style = "font-size:17px;color:#000;font-weight: bold;font-style:italic;">There Is No Books Now</a></p>
									<?php
									} 
									?>
						</div>
							<div class="course-author" style = "padding:5px;margin-left:25px;">
								<div class="ca-pic set-bg" data-setbg="img/authors/<?php echo $roww['image1'] ?>" style = "margin-top:15px;"></div>
								<p>DR : <?php echo $roww['tname'] ?>. <span>Software_Engineer</span></p>
								<br>
							</div>
							
						</div>
					</div>
				</div>
				<!-- course -->
				<?php }}
				else{ ?>
					<h1>YOU DO NOT HAVE ANY COURSES</h1>
					
			<?php 	}

				
				?>
			</div>
			
			</div>
	</section>
	<!-- course section end -->


	<!-- banner section -->
	<section class="banner-section spad">
		<div class="container">
			<div class="section-title mb-0 pb-2">
				<h2>Join Our Community Now!</h2>
				<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec malesuada lorem maximus mauris scelerisque, at rutrum nulla dictum. Ut ac ligula sapien. Suspendisse cursus faucibus finibus.</p>
			</div>
			<div class="text-center pt-5">
				<a href="#" class="site-btn">Register Now</a>
			</div>
		</div>
	</section>
	<!-- banner section end -->


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
		<?php
 include $tpl . "Footer.php";
 }
 else{
	 echo "<div style = 'margin-top:200px;' class = 'container'>";
			$msg = "<div class = 'alert alert-danger'>Sorry you can not browse this page directly</div>";
			redirect($msg,4);
			echo "</div>";
 }
 ?>
