    <!-- body area -->

    <div class="bodyContent">

      <div class="mContainer">



        <div class="createpost">

          <div class="createposth">

            <h4>Create New Post</h4>

          </div>





          <div class="row">

              <?php echo validation_errors(); ?>

        <?php $fattr = array('class' => 'col s12' ); echo form_open_multipart('admin/create',$fattr); ?> 

              <div class="row">

                <div class="col s12 m8">



                  <div class="row">

                    <div class="input-field col s12">

                      <i class="material-icons prefix">create</i>

                      <input id="titleTxt" name="postTitle" type="text" class="validate" required="required">

                      <label for="titleTxt">Post title</label>

                    </div>

                    <div class="input-field col s12">

                      <textarea name="postContent" id="mytextarea" >



                      </textarea>

                    </div>

                  </div>



                </div>



                <div class="col s12 m4">

                  <div class="row">



                    <div class="input-field col s12">

                      <?php if (isset($categories) && $categories !=''): ?>

                      <select name="category">

                        <option value="" disabled selected>Choose your option</option>

                        <?php foreach ($categories as $categoriy): ?>



                          <option value="<?php echo $categoriy['cat_name']; ?>"><?php echo $categoriy['cat_name']; ?></option>



                        <?php endforeach ?>

                        </select>

                      <label>Select a category</label>

                      <?php endif ?>

                    </div>



                    <div class="file-field input-field col s12">

                      <div class="btn">

                        <span>Thumbnail</span>

                        <input name="postThumbnail" type="file">

                      </div>

                      <div class="file-path-wrapper">

                        <input class="file-path validate" type="text">

                      </div>

                    </div>





                  <!-- Customizable input  -->

                  <div class="input-field col s12">

                      <label for="tags" class="hola">Tags</label>

                      <input type="text" name="tags" id="tags" value="" data-role="materialtags"/>

                  </div>



                  </div>





                </div>



                <div class="col s12 m8">

                  <input type="submit" class="btn green" name="" value="Submit">

                  <input type="reset" class="btn red" name="" value="Reset">

                </div>





              </div>

            </form>

          </div>



        </div>



      </div>

    </div>





<!--EDITOR TinyMCE -->

<script type="text/javascript" src="<?= base_url('assets'); ?>/js/jquery-3.4.1.min.js"></script>

  <script src="<?= base_url('assets/'); ?>tinymce/tinymce.min.js" type="text/javascript" charset="utf-8"></script>



<script type="text/javascript">

  tinymce.init({

    selector : '#mytextarea',

    plugins : 'image imagetools link',

    toolbar : 'image bold italic underline align blockquote link',

    relative_urls: false,

remove_script_host: false,



   // images_upload_url : 'admin/upload_tImg',

   // automatic_uploads : false,



    images_upload_handler : function(blobInfo, success, failure) {

      var xhr, formData;



      xhr = new XMLHttpRequest();

      xhr.withCredentials = false;

      xhr.open('POST', '<?php echo base_url('admin/upload_tImg') ?>');



      xhr.onload = function() {

        var json;



        if (xhr.status != 200) {

          failure('HTTP Error: ' + xhr.status);

          return;

        }



        json = JSON.parse(xhr.responseText);



        if (!json || typeof json.file_path != 'string') {

          failure('Invalid JSON: ' + xhr.responseText);

          return;

        }



        success(json.file_path);

      };



      formData = new FormData();

      formData.append('file', blobInfo.blob(), blobInfo.filename());



      xhr.send(formData);

    },

  });









</script>