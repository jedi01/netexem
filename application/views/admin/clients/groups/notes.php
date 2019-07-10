<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if(isset($client)){ ?>
<h4 class="customer-profile-group-heading"><?php echo _l('contracts_notes_tab'); ?></h4>
<div class="col-md-12">

 <a href="#" class="btn btn-success mtop15 mbot10" onclick="slideToggle('.usernote'); return false;"><?php echo _l('new_note'); ?></a>
 <div class="clearfix"></div>
<div class="row">
     <hr class="hr-panel-heading" />
</div>
 <div class="clearfix"></div>
 <div class="usernote hide">
    <?php echo form_open(admin_url( 'misc/add_note/'.$client->userid.'/customer')); ?>
    <?php echo render_textarea( 'description', 'note_description', '',array( 'rows'=>5)); ?>
    <button class="btn btn-info pull-right mbot15">
        <?php echo _l( 'submit'); ?>
    </button>
    <?php echo form_close(); ?>
</div>
<div class="clearfix"></div>
<div class="mtop15">
  <!-- Notes Customization Start -->
   <ul class="timeline">
     <?php 
     $classKey = 1; 
     foreach($user_notes as $note)
     {  
      if($classKey % 2 != 0)
      { 
        $liClass = "";
      }
      else
      {
        $liClass="timeline-inverted";
      }
      ?>
      <li class="<?php echo $liClass; ?>">
          <div class="timeline-badge"><i class="fa fa-comment-o"></i></div>
          <div class="timeline-panel">
          <div>
          <div class="col-md-2"><?php echo staff_profile_image($note['staffid'],array('custom_left')); ?></div>
            <div class="col-md-10 timeline-heading">
              <a href="<?php echo admin_url( 'profile/'.$note[ 'addedfrom']) ?>" class="timeline-title"><?php echo $note[ 'firstname'] . ' ' . $note[ 'lastname']; ?>&nbsp;<span class="custom_text">added a note</span></a>
              
              <p data-order="<?php echo $note['dateadded']; ?>"><small class="text-muted" >
                   <?php if(!empty($note['date_contacted'])){ ?>
           <span data-toggle="tooltip" data-title="<?php echo _dt($note['date_contacted']); ?>">
              <i class="fa fa-phone-square text-success font-medium valign" aria-hidden="true"></i>
          </span>
          <?php } ?>
          <?php echo _dt($note[ 'dateadded']); ?>
                </small>
              </p>

            </div>
          </div>
            <div class="timeline-body">
            
              <div data-note-description="<?php echo $note['id']; ?>">
                     <p> <?php echo check_for_links($note['description']); ?></p>
                </div>
                <div data-note-edit-textarea="<?php echo $note['id']; ?>" class="hide">
                    <textarea name="description" class="form-control" rows="4"><?php echo clear_textarea_breaks($note['description']); ?></textarea>
                    <div class="text-right mtop15">
                      <button type="button" class="btn btn-default" onclick="toggle_edit_note(<?php echo $note['id']; ?>);return false;"><?php echo _l('cancel'); ?></button>
                      <button type="button" class="btn btn-info" onclick="edit_note(<?php echo $note['id']; ?>);"><?php echo _l('update_note'); ?></button>
                  </div>
              </div>
              
              <?php if($note['addedfrom'] == get_staff_user_id() || is_admin()){ ?>
              <div class="row">
                <div class="col-md-1"><a href="#" class="custom_a" onclick="toggle_edit_note(<?php echo $note['id']; ?>);return false;">Edit</a></div>
                <div class="col-md-1"><a href="<?php echo admin_url('misc/delete_note/'. $note['id']); ?>" class="custom_a _delete">Delete</a></div>
                <div class="col-md-10"></div>
              </div>
                 <?php } ?>

            </div>
          </div>
        </li>
     
      <?php $classKey++; } ?>

    </ul>


  <!-- Notes Customization end -->

</div>
<?php } ?>
