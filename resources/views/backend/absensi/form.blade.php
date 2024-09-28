
  
  <!-- Modal -->
  <div class="modal fade" id="modal-agent" tabindex="-1" role="dialog" aria-labelledby="modal-agent">
    <div class="modal-dialog" role="document">

        <form action="" role="form" method="post" class="form-horizontal" data-toggle="validator">
            @csrf
            @method('post') 

      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           

            <div class="form-group row">
              <label for="jabatan" class="col-md-4 col-md-offset-1 control-label">Status</label>
              <div class="col-md-8">
                <select class="form-control" name="status" id="status">
                  <option disabled>Pilih Status</option>
                      <option value="3">Izin</option>
                      <option value="0">Sakit</option>
    
                </select>
                  <span class="help-block with-errors text-danger"></span>

              </div>
          </div>

            <div class="form-group row">
              <label for="deskripsi" class="col-md-4 col-md-offset-1 control-label">Keterangan</label>
              <div class="col-md-8">
                  <textarea class="form-control" name="keterangan" id="" cols="30" rows="5"></textarea>
                  <span class="help-block with-errors text-danger"></span>
  
              </div>
          </div>
         
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Keluar</button>
          <button class="btn btn-warning">Simpan</button>
        </div>
      </div>
    </form>
    </div>
  </div>
  