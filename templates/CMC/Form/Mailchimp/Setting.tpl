{* this template is used for adding/editing mailchimp setting  *}
<h3>
  {if $action eq 1}{ts}New Setting{/ts}{elseif $action eq 2}{ts}Edit Setting{/ts}{elseif $action eq 4}{ts}View Setting{/ts}{else}{ts}Delete Setting{/ts}{/if}
</h3>
<div class="crm-block crm-form-block crm-mailchimp-setting-form-block">
 {if $action neq 8}
    <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="top"}</div>
 {/if} 
 {if $action eq 8}
    <div class="messages status">
      <dl>
        <dt>
        <div class="icon inform-icon"></div>
        </dt>
        <dd>
          {ts}WARNING: Deleting this setting will prevent mailchimp script to execute for related list.{/ts} {ts}Do you want to continue?{/ts}
        </dd>
      </dl>
    </div>
        
  {else}
    <table class="form-layout-compressed">
      <tr class="crm-mailchimp-setting-form-block-label">
        <td class="label">{$form.base_url.label}</td>
        <td>{$form.base_url.html}&nbsp;<br/>
          <span class="description">{ts}WARNING: Please give proper URL.{/ts}</span>
        </td>
      </tr>
      <tr class="crm-mailchimp-setting-form-block-list-id">
        <td class="label">{$form.list_id.label}</td>
        <td>{$form.list_id.html}<br />
        <span class="description">{ts}List ID from mailchimp.{/ts}</span></td>
      </tr>
      <tr class="crm-mailchimp-setting-form-block-api-key">
        <td class="label">{$form.api_key.label}</td>
        <td>{$form.api_key.html}<br/>
            <span class="description">{ts}Api key from mailchimp.{/ts}</span>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>{$form.is_active.html} {$form.is_active.label}</td>
      </tr>
    </table>
  {/if}
  <div class="crm-submit-buttons">{include file="CRM/common/formButtons.tpl" location="bottom"}</div>
</div>
{literal}
<script type="text/javascript">
</script>
{/literal}
