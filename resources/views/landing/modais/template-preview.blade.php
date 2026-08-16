<style>
  #previewGallery img {
    width: 80px;
    height: 60px;
    object-fit: cover;
    cursor: pointer;
    border-radius: 6px;
    transition: 0.2s;
    opacity: 0.8;
  }

  #previewGallery img:hover {
    opacity: 1;
    transform: scale(1.05);
  }
  
</style>

<div class="modal fade" id="templatePreviewModal" tabindex="-1">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable ">
    <div class="modal-content modal-with-sidebar">

      <div class="modal-header">
        <h5 class="modal-title" id="previewTitle"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body text-center">
        <img id="previewImg" class="img-fluid mb-3 rounded-3" />

        <div id="previewGallery" class="mb-3 d-flex gap-2 flex-wrap justify-content-center"></div>

        <p id="previewDesc"></p>
      </div>

    </div>
  </div>
</div>