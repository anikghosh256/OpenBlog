<div class="mContainer userPanel">
	
	<div class="row ">

		<div class="col s12 m12 l4">
			<div class="card">
				<div class="profileWrap"  style="background-image:url('<?php echo base_url(); ?>images/profileCover.jpg')">
					<div class="profileImg">
						<img src="<?php echo base_url(); ?>images/profile/<?php echo $UserInfo['userImg']; ?>">
					</div>
					<div class="profileEdit">
						<div class="btn-floating btn-large "><a href="<?php echo base_url('member/edit/'.$this->session->userdata('username')); ?>"><i class="large material-icons">mode_edit</i></a></div>
					</div>
				</div>
				<div class="userDetils">
					<ul class="collection with-header">
				        <li class="collection-header">
				       		<h4><?php echo $UserInfo['fullName']; ?> <span class="userRole"><?php echo $UserInfo['userPosition']; ?></span></h4>
				       	</li>
				        <li class="collection-item">
				       		<div>Username <span class="secondary-content"><?php echo $UserInfo['userName']; ?></span></div>
				       	</li>
				       	<li class="collection-item">
				       		<div>Email <span class="secondary-content"><?php echo $UserInfo['email']; ?></span></div>
				       	</li>
				       	<li class="collection-item">
				       		<div>Gender <span class="secondary-content"><?php echo $UserInfo['gender']; ?> </span></div>
				       	</li>
				       	<li class="collection-item">
				       		<div>Birth-Date <span class="secondary-content">
				       			<?php if ($UserInfo['birthDate'] != NULL): ?>
				       				<?php echo date("d M Y",strtotime( $UserInfo['birthDate'])); ?>
				       				<?php else: ?>
				       					<?php echo 'unset'; ?> 
				       			<?php endif ?>
				       		</span></div>
				       	</li>
				       	<li class="collection-item">
				       		<div>Join Date <span class="secondary-content"><?php echo date("d M Y",strtotime( $UserInfo['resOn'])); ?></span></div>
				       	</li>
				       	<li class="collection-item">
				       		<div>Change Password <a href="#" class="secondary-content">Try Later</a></div>
				       	</li>
				       	<?php if ($this->session->userdata('user_role')== 'admin'): ?>
				       		<li class="collection-item">
				       		<div>Admin dashboard <a href="<?php echo base_url('admin'); ?>" class="secondary-content">Dashboard</a></div>
				       	</li>
				       	<?php endif ?>
				       	<li class="collection-item">
				       		<div>Log out <a href="<?php echo base_url('Logout') ?>" class="secondary-content">logout</a></div>
				       	</li>
				       
				     </ul>
				</div>

			</div>
		</div>

		<div class="col s12 m12 l8">
			<div class="card recentPostU">
				<div class="recentPostsWrap">
			<!-- flash message -->
			  <?php if($this->session->flashdata('profileUpdated')): ?>
                <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('profileUpdated').' <i class="close material-icons">close</i></div>'; ?>
              <?php endif; ?>
          <!-- flash massage end -->
					<div class="headerR">
						<h4>Recent Activities</h4>
					</div>
					<div class="row recentPostsW">
						<?php if (isset($activities) && $activities): ?>

							<?php foreach ($activities as $activity): ?>

								<div class="col s12 m12">
							      <div class="card grey lighten-4" style="box-shadow: none;">
							        <div class="card-content ">
							          <span class="card-title"><?php echo $activity['acc_for']; ?></span>
							          <p><?php echo $activity['acc_message']; ?>.</p>
							          <hr>
							          <small style="float: right;"> on-- <?php echo date("d M Y h:i A",strtotime($activity['acc_on'])); ?></small>
							        </div>
							        
							      </div>
							    </div>
							    
							<?php endforeach; ?>
							<?php else: ?>
								<div class="headerR">
									<p>nothing to show..!</p>
								</div>
						<?php endif; ?>


					  </div>
				</div>
			</div>
		</div>

	</div>

</div>