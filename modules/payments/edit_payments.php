<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add or Update Received Amounts</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-10 offset-sm-1">
                        <form id="update_Payment_Form">
                            <div class="form-group text-left">
                                <label>Received Amount <span class="required">*</span></label>
                                <input id="received_amount" type="number" min=0 name="received_amount"
                                    required="required" class="form-control">
                            </div>
                            <br>
                            <input type="hidden" name="user_id" id="user_id">
                            <input name="hiddenpaymentid" id="hiddenpaymentid" value="" type="hidden">
                            <!-- <div class="">
                                <label for="project_start_date">Received Date <abbr title="Required">*</abbr></label>
                                <div class="d-flex ">
                                    <input class="form-control" type="date" id="html5-date-input" name="received_date"/>
                                </div>
                            </div> -->
                            <div>
                                <input type="submit" id="update_Record" value="UPDATE"
                                    class="btn btn-primary btn-small float-left" name="update_record" />
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
