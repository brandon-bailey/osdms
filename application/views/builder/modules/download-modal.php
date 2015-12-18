            <div class="modal fade" role="dialog" id="downloadModal">
                  <div class="modal-dialog">
                        <div class="modal-content">
                              <div class="modal-header">
                                    <a class="close" data-dismiss="modal"></a>
                                    <h3>Save Module</h3>
                              </div>
                              <div class="modal-body">
                                    <form role="form">
                                          <div class="form-group">
                                          <label for="category">Select Module Category</label> 
                                          <select class="form-control" id="category" name="category">
                                                <option value="header" id="header">Header</option>
                                                <option value="body" id="body">Body</option>
                                                <option value="footer" id="footer">Footer</option>
                                          </select> 
                                          <span class="help-block">This will organize the module on the document build
                                          page.</span></div>
                                          <br />
                                          <div class="form-group">
                                          <label for="description">Type a brief description</label> 
                                          <input type="text" class="form-control" id="description" required="" /> 
                                          <span class="help-block">This will give other users a better understanding of this
                                          module.</span></div>
                                          <textarea style="display:none;"></textarea>
                                          <br />
                                          <br />
                                          <button id="saveModule" class="btn btn-primary" type="button">Save</button>
                                    </form>
                              </div>
                              <div class="modal-footer">
                                    <a class="btn btn-danger" data-dismiss="modal">Close</a>
                              </div>
                        </div>
                  </div>
            </div>