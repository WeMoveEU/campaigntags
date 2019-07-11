{if $form.tag.html}
<table id="campaigntags_src">
  <tr class="crm-campaign-form-block-tag">
    <td class="label">{$form.tag.label}</td>
    <td class="view-value">
      <div class="crm-select-container">{$form.tag.html}</div>
    </td>
  </tr>
</table>
{/if}

{if $form.taggoals.html}
<table id="campaigntaggoalss_src">
  <tr class="crm-campaign-form-block-taggoals">
    <td class="label">{$form.taggoals.label}</td>
    <td class="view-value">
      <div class="crm-select-container">{$form.taggoals.html}</div>
    </td>
  </tr>
</table>
{/if}

{literal}
<script type="text/javascript">
  cj(function($) {
    $('#campaigntags_src tr').detach().insertAfter('.crm-campaign-form-block-includeGroups');
    $('#campaigntags_src').remove();
    $('#campaigntaggoalss_src tr').detach().insertAfter('.crm-campaign-form-block-includeGroups');
    $('#campaigntaggoalss_src').remove();
  });
</script>
{/literal}
