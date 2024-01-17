<script type="text/javascript">
jQuery(document).ready(function(){
    jQuery('.eb_date').datepicker({
        dateFormat: 'dd M yy'
    });
});
</script>
    <p>
    <label for="eb_start_date_field" style="display:inline-block; min-width: 70px;">Start Date</label>
    <input name="eb_start_date_field" class="eb_date" id="eb_start_date_field" class="postbox" value="<?=$startDate ? date("d M y", $startDate): ''?>" />
   
</p>
    <p>

    <label for="eb_end_date_field" style="display:inline-block; min-width: 70px">End Date</label>
    <input name="eb_end_date_field" class="eb_date" id="eb_end_date_field" class="postbox" value="<?=$endDate ? date("d M y", $endDate): ''?>" />
   
</p>
    <p>

    <label for="eb_address_field" style="display:inline-block; min-width: 70px">Address</label>
    <input name="eb_address_field" style="margin-bottom: 0;" id="eb_address_field" class="postbox" value="<?=$address?>" />

</p>

