   <!-- body area -->
    <div class="bodyContent">
      <div class="mContainer">
			<!-- flash massage -->

			    <?php if($this->session->flashdata('wrong')): ?>
	              <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('wrong').' <i class="close material-icons">close</i></div>'; ?>
	            <?php endif; ?>

			    <?php if($this->session->flashdata('sCreaded')): ?>
	              <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('sCreaded').' <i class="close material-icons">close</i></div>'; ?>
	            <?php endif; ?>
	            <?php if($this->session->flashdata('sUpdated')): ?>
	              <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('sUpdated').' <i class="close material-icons">close</i></div>'; ?>
	            <?php endif; ?>

	            <?php if($this->session->flashdata('sDeleted')): ?>
	              <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('sDeleted').' <i class="close material-icons">close</i></div>'; ?>
	            <?php endif; ?>
			    
			    <!-- flash massage end -->
        <div class="createpost">
          <div class="createposth">
            <h4><?= $pageTitle; ?> </h4>
            <hr>
          </div>


          <div class="row">
          	<div class="col s12">
          		<?php echo validation_errors(); ?>
             <?php $fattr = array('class' => 'row' ); echo form_open_multipart('admin/addSLink',$fattr); ?>
          			<div class="input-field col s12 m3">
          			  <i class="material-icons prefix">bookmark</i>
			          <input name="SocialName"  id="social_name" type="text" class="validate">
			          <label for="social_name">Name</label>
			        </div>
			        <div class="input-field col s12 m4">
          			  <i class="material-icons prefix">bookmark</i>
			          <input name="socialLink"  id="social_url" type="text" class="validate">
			          <label for="social_url">Social URL</label>
			        </div>

			        <div class="input-field col s12 m3">
          			  <i class="material-icons prefix">tag_faces</i>
			          <input name="socialIcon"  id="fontaIcons" type="text" class="validate">
			          <label for="fontaIcons">Fontawesome Icon</label>
			        </div>

			        <div class="input-field col s12 m2">
			          <button class="btn green waves-effect">Add</button>
			        </div>
          		</form>
          	</div>
            <table   class="col s12 striped highlight">
             	<thead>
             		<tr>
             			<th>Name</th>
             			<th>Fontawesome Icon</th>
             			<th>Social URL</th>
             			<th>Edit</th>
             			<th>Delete</th>
             		</tr>
             	</thead>
             	<tbody>

             		<?php if (isset($socialIcons) && $socialIcons): ?>
             			<?php foreach ($socialIcons as $socialIcon): ?>
             				<tr>
		             			<td><?php echo $socialIcon['link_name']; ?></td>		             	
		             			<td><?php echo $socialIcon['link_icon']; ?></td>
		             			<td><?php echo $socialIcon['url']; ?></td>
		             			<td><a class="btn green" href="<?php echo base_url('admin/sLinkEdit/'.$socialIcon['link_id']) ?>">Edit</a></td>
		             			<td>
									<!-- Modal Trigger -->
									  <a class="waves-effect waves-light btn red modal-trigger" href="#<?php echo $socialIcon['link_id']; ?>">Delete</a>

									  <!-- Modal Structure -->
									  <div id="<?php echo $socialIcon['link_id']; ?>" class="modal">
									    <div class="modal-content">
									      <h4>Are you sure?</h4>
									      <p>you want to delete Social Link..</p>
									    </div>
									    <div class="modal-footer">
									      <a  class="btn modal-close waves-effect red" href="<?php echo base_url('admin/sLinkDelete/'.$socialIcon['link_id']) ?>">Yes</a>
									    </div>
									  </div>

		             			</td>
		             		</tr>
             			<?php endforeach ?>
             		<?php endif ?>
             		
             	</tbody>
             </table>
      
          </div>

        </div>

      </div>
    </div>