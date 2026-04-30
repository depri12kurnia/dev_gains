  <!-- summernote -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/depri12kurnia/assetsadminlte3.2.0@19d5f7d70f5a32386894c2573713049dc9e2e5f0/plugins/summernote/summernote-bs4.min.css">
  <div class="row">
      <div class="col-12">
          <div class="card card-info">
              <div class="card-header">
                  <h3 class="card-title">Master Data News</h3>
                  <button class="card-title btn btn-success btn-sm float-right" onclick="add_news()"><i class="fa fa-plus"></i> Add</a></button>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                  <table id="table" class="table table-bordered table-hover small">
                      <thead>
                          <tr>
                              <th>#</th>
                              <th>Category</th>
                              <th>Title</th>
                              <th>Author</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </thead>
                      <tbody>
                          <!-- Datatables -->
                      </tbody>
                      <tfoot>
                          <tr>
                              <th>#</th>
                              <th>Category</th>
                              <th>Title</th>
                              <th>Author</th>
                              <th>Status</th>
                              <th>Action</th>
                          </tr>
                      </tfoot>
                  </table>
              </div>
              <!-- /.card-body -->
          </div>
          <!-- /.card -->
      </div>
      <!-- /.col -->
  </div>

  <!-- Bootstrap modal -->
  <div class="modal fade" id="modal_form" role="dialog">
      <div class="modal-dialog modal-xl">
          <div class="modal-content">
              <div class="modal-header">
                  <h3 class="modal-title">News Form</h3>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>

              </div>
              <div class="modal-body form">
                  <form action="#" id="form" class="form-horizontal">
                      <input type="hidden" value="" name="id" />
                      <div class="form-body">
                          <div class="form-group">
                              <label>Category *</label>
                              <select name="category_id" class="form-control">
                                  <?php foreach ($category as $c): ?>
                                      <option value="<?php echo $c->id; ?>"><?php echo $c->name; ?></option>
                                  <?php endforeach; ?>
                              </select>
                              <span class="help-block"></span>
                          </div>
                          <div class="form-group">
                              <label>Title *</label>
                              <input name="title" placeholder="Title" class="form-control" type="text">
                          </div>
                          <div class="form-group">
                              <label>Content *</label>
                              <textarea id="content" name="content" placeholder="Content" class="form-control"></textarea>
                          </div>
                          <div class="form-group">
                              <label>Status</label>
                              <select name="status" class="form-control">
                                  <option value="draft">Draft</option>
                                  <option value="published">Published</option>
                              </select>
                          </div>
                          <div class="form-group">
                              <label>Thumbnail</label>
                              <input id="thumbnail" name="thumbnail" type="file" class="form-control">
                          </div>
                          <div class="form-group">
                              <img id="thumbnail-preview" src="" alt="Preview" class="img-thumbnail" style="max-width: 200px; display: none;">
                          </div>

                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-primary" id="btnSave">Save</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                      </div>
                  </form>
              </div>
          </div>
      </div>
  </div>
  <input type="hidden" id="csrf_token" name="csrf_token_jkt3" value="<?= $this->security->get_csrf_hash(); ?>">

  <!-- Summernote -->
  <script src="https://cdn.jsdelivr.net/gh/depri12kurnia/assetsadminlte3.2.0@19d5f7d70f5a32386894c2573713049dc9e2e5f0/plugins/summernote/summernote-bs4.min.js"></script>
  <script>
      $(function() {
          $('#content').summernote({
              height: 100, // Ubah tinggi sesuai kebutuhan (dalam pixel)
              minHeight: 200, // Minimum height
              maxHeight: 500, // Maximum height
              focus: true // Fokus ke editor saat dibuka
          });
      })
  </script>
  <script type="text/javascript">
      var save_method;
      var table;

      function getCsrfToken() {
          let token = document.cookie.split('; ')
              .find(row => row.startsWith('csrf_cookie_jkt3='))
              ?.split('=')[1] || '';

          // console.log("CSRF Token dari Cookie:", token); // Debug
          return token;
      }

      function getCookie(name) {
          let matches = document.cookie.match(new RegExp(
              "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
          ));
          return matches ? decodeURIComponent(matches[1]) : undefined;
      }

      $(document).ajaxSend(function(e, xhr, options) {
          let csrfToken = $('meta[name="csrf-token"]').attr('content');
          if (csrfToken) {
              xhr.setRequestHeader('X-CSRF-Token', csrfToken);
          }
      });

      $(document).ready(function() {
          table = $('#table').DataTable({
              "processing": true,
              "serverSide": true,
              "responsive": true,
              "autoWidth": false,
              "lengthChange": true,
              "ajax": {
                  "url": "<?php echo site_url('admin/news/ajax_list') ?>",
                  "type": "POST",
                  "data": function(d) {
                      d.csrf_token_jkt3 = getCsrfToken(); // Kirim CSRF token sebagai data POST
                  },
                  "error": function(xhr) {
                      console.log("Error:", xhr.responseText);
                  }
              }

          });
      });

      function add_news() {
          save_method = 'add';
          $('#form')[0].reset();
          $('.form-group').removeClass('has-error');
          $('.help-block').empty();
          $('#modal_form').modal('show');
          $('.modal-title').text('Add News');
      }

      function edit_news(id) {
          save_method = 'update';
          $('#form')[0].reset();
          $('.form-group').removeClass('has-error');
          $('.help-block').empty();
          $.ajax({
              url: "<?php echo site_url('admin/news/ajax_edit/') ?>" + id,
              type: "GET",
              dataType: "JSON",
              success: function(data) {
                  $('[name="id"]').val(data.id);
                  $('[name="category_id"]').val(data.category_id);
                  $('[name="title"]').val(data.title);
                  $('#content').summernote('code', data.content); // Fix untuk Summernote
                  $('[name="status"]').val(data.status);
                  $('#modal_form').modal('show');
                  $('.modal-title').text('Edit News');

                  // Set format untuk input date
                  if (data.published_at) {
                      $('[name="published"]').val(data.published_at);
                  } else {
                      $('[name="published"]').val('');
                  }

                  // Pratinjau gambar thumbnail lama
                  if (data.thumbnail) {
                      $('#thumbnail-preview').attr('src', "<?php echo base_url('public/uploads/news/') ?>" + data.thumbnail);
                      $('#thumbnail-preview').show();
                  } else {
                      $('#thumbnail-preview').hide();
                  }
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error getting data from ajax');
              }
          });
      }

      function delete_news(id) {
          if (confirm('Are you sure delete this data?')) {
              $.ajax({
                  url: "<?php echo site_url('admin/news/ajax_delete/') ?>" + id,
                  type: "POST",
                  data: {
                      csrf_token_jkt3: getCsrfToken()
                  }, // Kirim CSRF token

                  dataType: "JSON",
                  success: function(data) {
                      $('#modal_form').modal('hide');
                      reload_table();

                      // debug
                      // console.log("Token CSRF baru:", data.csrf_token);
                      // Perbarui CSRF token setelah request berhasil
                      document.cookie = "csrf_cookie_jkt3=" + data.csrf_token + "; path=/";
                  },
                  error: function(jqXHR, textStatus, errorThrown) {
                      alert('Error deleting data');
                  }
              });
          }
      }

      $('#btnSave').click(function() {
          var url;
          if (save_method == 'add') {
              url = "<?php echo site_url('admin/news/ajax_add') ?>";
          } else {
              url = "<?php echo site_url('admin/news/ajax_update') ?>";
          }

          var formData = new FormData($('#form')[0]); // Gunakan FormData untuk menangani file

          // Ambil file thumbnail secara manual
          var fileInput = document.getElementById('thumbnail');
          if (fileInput.files.length > 0) {
              formData.append('thumbnail', fileInput.files[0]);
          }

          // Tambahkan CSRF token
          formData.append('csrf_token_jkt3', getCsrfToken());

          $.ajax({
              url: url,
              type: "POST",
              data: formData,
              dataType: "JSON",
              processData: false, // Jangan ubah data agar bisa mengirim file
              contentType: false, // Jangan set content type agar browser menangani multipart/form-data
              beforeSend: function(xhr) {
                  xhr.setRequestHeader("X-CSRF-Token", getCsrfToken());
              },
              success: function(data) {
                  if (data.status) {
                      $('#modal_form').modal('hide');
                      reload_table();
                  } else {
                      for (var i = 0; i < data.inputerror.length; i++) {
                          $('[name="' + data.inputerror[i] + '"]').parent().addClass('has-error');
                          $('[name="' + data.inputerror[i] + '"]').next().text(data.error_string[i]);
                      }
                  }

                  // Perbarui CSRF token setelah request berhasil
                  document.cookie = "csrf_cookie_jkt3=" + data.csrf_token + "; path=/";
              },
              error: function(jqXHR, textStatus, errorThrown) {
                  alert('Error adding / updating data');
              }
          });
      });

      function reload_table() {
          table.ajax.reload(null, false);
      }

      $('#modal_form').on('hidden.bs.modal', function() {
          table.ajax.reload(null, false); // Reload DataTables tanpa reset pagination
      });

      $('.btn-default').click(function() {
          $('#modal_form').modal('hide'); // Menutup modal
          table.ajax.reload(null, false); // Reload DataTables
      });
  </script>