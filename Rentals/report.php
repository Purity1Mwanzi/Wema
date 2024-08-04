<?php
session_start();
if (!isset($_SESSION['SESSION_EMAIL'])) {
  header("Location: index.php");
  die();
}

include 'config.php';
include ('admin\includes\header.php');
include ('admin\includes\navbar.php');
include ('admin\includes\scripts.php')




  ?>




<div class="layout__content">
  <div id="feedbackModal"></div>
  <div>
    <div class="MuiBackdrop-root jss1" aria-hidden="true"
      style="opacity: 0; transition: opacity 195ms cubic-bezier(0.4, 0, 0.2, 1) 0ms; visibility: hidden;">
      <div class="MuiCircularProgress-root MuiCircularProgress-indeterminate" role="progressbar"
        style="width: 40px; height: 40px;">
        <svg class="MuiCircularProgress-svg" viewBox="22 22 44 44">
          <circle class="MuiCircularProgress-circle MuiCircularProgress-circleIndeterminate" cx="44" cy="44" r="20.2"
            fill="none" stroke-width="3.6"></circle>
        </svg>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="row">

      <div class="col-lg-9" style="min-width: 220px;">
        <div class="mb-2 _2FwYJSSiz4rgRt6CoVCwk7 card">
          <div class="d-flex justify-content-between h5 bg-white text-indigo _1wKHkO6cYDJ1VuvERIhU4e card-header">
            <span style="color: rgb(22, 15, 171);">Report</span>
            <a class="collapse show" href="#" data-toggle="collapse" data-target="#collapse" aria-expanded="true"
              aria-controls="collapse">
              <i class="ml-auto fa fa-fw fa-minus"></i>
            </a>
          </div>
          <div id="collapse" class="collapse show">
            <!-- Collapsible content goes here -->
            <div class="pt-0 card-body">
              <div class="col-lg-12">
                <div class="col-lg-12">
                  <div class="mb-2 row">
                    <div class="col-md-12 col-lg-12">
                      <div class="row">

                      </div>
                      <div class="col-12 col-sm-6 col-md-7 col-lg-8">
                        <div class="form-group">
                          <label for="tenantId" class="h6">Select Tenant</label>
                          <div class="rbt" tabindex="-1" style="outline: none; position: relative;">
                            <div style="display: flex; flex: 1 1 0%; height: 100%; position: relative;width: 100%;">
                              <input autocomplete="off" type="text" aria-autocomplete="both" aria-expanded="false"
                                aria-haspopup="listbox" role="combobox" class="rbt-input-main form-control rbt-input"
                                value="">
                              <input aria-hidden="true" class="rbt-input-hint" readonly="" tabindex="-1" value=""
                                style="background-color: transparent; border-color: transparent; box-shadow: none; color: rgba(0, 0, 0, 0.35); left: 0px; pointer-events: none; position: absolute; top: 0px; width: 100%; border-style: solid; border-width: 1px; font-size: 14px; height: 36.3906px; line-height: 22.4px; margin: 0px; padding: 6px 12px;">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="d-flex row">
                  <div class="mb-3 col-sm-12 col-md-6 col-lg-6">
                    <button type="submit" id="submit" disabled="" class="mx-1  btn btn-secondary disabled"
                      style="width: 65%; background-color: #4e73df;">Submit</button>
                  </div>
                  <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="d-flex justify-content-center row">
                      <div class="col">
                        <button type="submit" id="downloadPdf" disabled=""
                          class="mb-1 bg-white shadow btn btn-secondary disabled"
                          style="width: 65%; border-color: #4e73df; color: rgb(0, 0, 130);">Download PDF</button>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>
</div>