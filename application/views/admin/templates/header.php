<!DOCTYPE html>

<html>

  <head>

    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>

    <title><?= $pageTitle ?></title>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

    <link rel="stylesheet" href="<?php echo base_url('assets/') ?>css/materialize.min.css">

    <link rel="stylesheet" href="<?php echo base_url('assets/admins/') ?>css/materialize-tags.css">

    <link rel="stylesheet" href="<?php echo base_url('assets/admins/') ?>css/style.css">

    

  </head>

  <body>

    <!-- header area -->

    <header>



      <!-- main nav -->

      <nav>

        <div class="nav-wrapper mContainer">

          <a href="<?php echo base_url('admin'); ?>" class="brand-logo left">Admin DashBoard</a>

          <ul id="nav-mobile" class="right hide-on-med-and-down">

            <li><a href="<?php echo base_url(); ?>">Home</a></li>

            <li><a href="<?php echo base_url('member'); ?>">Profile</a></li>

            

          </ul>



          <a href="#" data-target="slide-out" class="sidenav-trigger right"><i class="material-icons">menu</i></a>

        </div>

      </nav>

      <!-- slide nav -->

      <ul id="slide-out" class="sidenav">

          <li>

            <div class="user-view">

              <div class="background">

                <img src="<?php echo base_url(); ?>images/profile/profile_cover.jpg">

              </div>

              <a href="#user"><img class="circle" src="<?php echo base_url(); ?>images/profile/<?php echo $lUser['userImg']; ?>"></a>

              <a title="<?php echo $lUser['fullName']; ?>"><span class="white-text name"><?php echo $lUser['fullName']; ?></span></a>

              <a ><span class="white-text email"><?php echo $lUser['email']; ?></span></a>

            </div>

          </li>



          <li class="slidOp">

            <a href="<?php echo base_url('admin'); ?>">DashBoard</a>

          </li>



          <li>

            <ul class="collapsible">

              <li class="slidOp">

                <div class="collapsible-header"><i class="large material-icons">mode_edit</i>Post's</div>

                <div class="collapsible-body">

                  <ul>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/create'); ?>"><i class="Small material-icons">add_box</i>Create New Post</a>

                    </li>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/edit'); ?>"><i class="Small material-icons">mode_edit</i>Edit Post</a>

                    </li>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/delete'); ?>"><i class="Small material-icons">delete</i>Delete Post</a>

                    </li>

                  </ul>

                </div>

              </li>

              <li class="slidOp">

                <div class="collapsible-header"><i class="material-icons">category</i>Categories</div>

                <div class="collapsible-body">

                  <ul>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/Categories'); ?>"><i class="Small material-icons">add_box</i>Create New category</a>

                    </li>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/Categories'); ?>"><i class="Small material-icons">mode_edit</i>Edit category</a>

                    </li>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/Categories'); ?>"><i class="Small material-icons">delete</i>Delete category</a>

                    </li>

                  </ul>

                </div>

              </li>

              <li class="slidOp">

                <div class="collapsible-header"><i class="material-icons">comment</i>Comment's</div>

                <div class="collapsible-body">

                  <ul>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/comments'); ?>"><i class="Small material-icons">visibility</i>View Comment's</a>

                    </li>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/comments'); ?>"><i class="Small material-icons">delete</i>Delete Comment</a>

                    </li>

                  </ul>

                </div>

              </li>

              <li class="slidOp">

                <div class="collapsible-header"><i class="material-icons">contacts</i>User's</div>

                <div class="collapsible-body">

                  <ul>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/users'); ?>"><i class="Small material-icons">visibility</i>View All User's</a>

                    </li>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/users'); ?>"><i class="Small material-icons">delete</i>Delete users</a>

                    </li>

                  </ul>

                </div>

              </li>

              <li class="slidOp">

                <div class="collapsible-header"><i class="material-icons">settings</i>Settings</div>

                <div class="collapsible-body">

                  <ul>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/socialIcons'); ?>"><i class="Small material-icons">visibility</i>Social Icon's</a>

                    </li>

                    <li class="slidOpd">

                      <a href="<?php echo base_url('admin/websiteDetails'); ?>"><i class="Small material-icons">library_books</i>WesSite Details</a>

                    </li>

                  </ul>

                </div>

              </li>



            </ul>

          </li>

          <li class="slidOp">

            <a href="<?php echo base_url(); ?>"><i class="Small material-icons">home</i>Home</a>

          </li>

      </ul>

    </header>

