        
    <!-- body area -->
    <div class="bodyContent">
      <div class="mContainer">
          <!-- flash massage end -->
              <?php if($this->session->flashdata('post_created')): ?>
                <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('post_created').' <i class="close material-icons">close</i></div>'; ?>
              <?php endif; ?>
              <?php if($this->session->flashdata('profileUpdated')): ?>
                <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('profileUpdated').' <i class="close material-icons">close</i></div>'; ?>
              <?php endif; ?>

              <?php if($this->session->flashdata('wrong')): ?>
                <?php echo '<div class="chip alertBarD" style="text-align:center">'.$this->session->flashdata('wrong').' <i class="close material-icons">close</i></div>'; ?>
              <?php endif; ?>
              <?php if($this->session->flashdata('post_updated')): ?>
                <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('post_updated').' <i class="close material-icons">close</i></div>'; ?>
              <?php endif; ?>

              <?php if($this->session->flashdata('post_deleted')): ?>
                <?php echo '<div class="chip alertBarS" style="text-align:center">'.$this->session->flashdata('post_deleted').' <i class="close material-icons">close</i></div>'; ?>
              <?php endif; ?>
          <!-- flash massage end -->

        <!-- post's and comment count -->
        <div class="postCommentcount">

          <dic class="row" style="margin-bottom: 40px; display: block;">
            <h5>Website Performance</h5>
            <hr>
            <div class="col s12 m8">
              <div id="chart_div" style="width: 100%; height: 300px;"></div>
            </div>

            <div class="col s12 m4">
              <table style="margin-top:25px;">
                <tbody>
                  <tr>
                    <td>Pageviews today</td>
                    <td><?php echo array_values(array_slice($views, -1))[0]['page_view']; ?></td>

                  </tr>

                  <tr>
                    <td>Pageviews yesterday</td>
                    <td><?php echo array_values(array_slice($views, -2))[0]['page_view']; ?></td>

                  </tr>
                  <tr>
                    <td>Pageviews last 30 days</td>
                    <td>
                      <?php if(isset($views) && $views): ?>
                        <?php $viewCount=0; ?>
                        <?php foreach ($views as $view): ?>
                          <?php $viewCount += $view['page_view']; ?>
                        <?php endforeach ?>
                        <?php echo $viewCount; ?>
                    <?php endif; ?>

                    </td>

                  </tr>

                  <tr>
                    <td>Pageviews all time history</td>
                    <td><?php echo $allTimePageView; ?></td>

                  </tr>

                  <tr>
                    <td>Unique visit all time history</td>
                    <td><?php echo $allTimeUniqueView; ?></td>

                  </tr>

                </tbody>
              </table>
            </div>
          </dic>

          <div class="row" style="margin-bottom: 40px; display: block;">
            <div class="col s12 m4">
              <div class="card #424242 grey darken-3">
                <div class="card-content white-text">
                  <span class="card-title"><a class="collection-item green-text"><span class="new  badge"data-badge-caption="Post"><?php echo $getPostComCount['postCount']; ?></span>Total Post's</a></span>
                  <p>Write more Blog and get more view.</p>
                </div>
                <div class="card-action ">
                  <a href="<?php echo base_url('admin/create'); ?>" title="Create New Post" class="left"><i class="Small material-icons">add_box</i></a>
                  <a href="<?php echo base_url('admin/edit'); ?>" title="View All Post's" class="right"><i class="Small material-icons">visibility</i></a>
                  <br>
                </div>
              </div>
            </div>

            <div class="col s12 m4">
              <div class="card #37474f blue-grey darken-3">
                <div class="card-content white-text">
                  <span class="card-title"><a class="collection-item green-text"><span class="new  badge"data-badge-caption="Comment"><?php echo $getPostComCount['comCount']; ?></span>Total Comment's</a></span>
                  <p>Write more Blog and get more view.</p>
                </div>
                <div class="card-action ">
                  <a href="#" title="View All Comment's" class="right"><i class="Small material-icons">visibility</i></a>
                  <br>
                </div>
              </div>
            </div>

            <div class="col s12 m4">
              <div class="card #424242 grey darken-3">
                <div class="card-content white-text">
                  <span class="card-title"><a class="collection-item green-text"><span class="new  badge"data-badge-caption="View"><?php echo $allTimePageView; ?></span>Total View</a></span>
                  <p>Write more Blog and get more view.</p>
                </div>
                <div class="card-action ">
                  <a href="<?php echo base_url('admin/create'); ?>" title="Create New Post" class="left"><i class="Small material-icons">add_box</i></a>
                  <a href="<?php echo base_url('admin/edit'); ?>" title="View All Post's" class="right"><i class="Small material-icons">visibility</i></a>
                  <br>
                </div>
              </div>
            </div>
          </div>
        </div>
          



        <div class="recentPosts" style="margin-bottom: 40px; display: block;">
          <div class="postHeader">
            <h4>Recent Post's</h4>
            <hr>
          </div>

          <div class="row">

            <?php if (isset($recentPosts) && $recentPosts): ?>
              <?php foreach ($recentPosts as $recentPost): ?>
                
                <div class="col s12 m4">
                  <div class="card">
                    <div class="card-image waves-effect waves-block waves-light">
                      <img class="activator" src="<?php echo base_url('images/290x170/'.$recentPost['post_thumb']) ?>">
                    </div>
                    <div class="card-content">
                      <span class="card-title activator grey-text text-darken-4 truncate"><?php echo $recentPost['post_title']; ?><i class="material-icons right">more_vert</i></span>
                      

                      <div class="card-action ">
                        <a href="<?php echo base_url('admin/edit/'.$recentPost['post_slug']); ?>" title="Create New Post" class="left"><i class="Small material-icons">create</i></a>
                        <a href="<?php echo base_url('post/'.$recentPost['post_slug']); ?>" title="View All Post's" class="right"><i class="Small material-icons">visibility</i></a>
                        <br>
                      </div>
                    </div>
                    <div class="card-reveal">
                      <span class="card-title grey-text text-darken-4"><?php echo $recentPost['post_title']; ?><i class="material-icons right">close</i></span>
                      <p><?php echo strip_tags(substr($recentPost['post_content'], 0, 600)).'...'; ?></p>
                    </div>
                  </div>
                </div>

              <?php endforeach ?>
            <?php endif ?>
            
          </div>
        </div>

      </div>
    </div>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Page View', 'Unique Visit'],
          <?php if(isset($views) && $views): ?>
              <?php foreach ($views as $view): ?>
                ['<?php echo $view['date']; ?>',  <?php echo $view['page_view']; ?>,      <?php echo $view['unique_visit']; ?>],
              <?php endforeach ?>
          <?php endif; ?>
        ]);

        

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
        chart.draw(data, null);
      }
    </script>


