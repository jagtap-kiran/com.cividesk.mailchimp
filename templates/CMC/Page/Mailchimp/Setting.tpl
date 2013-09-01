<div id="help">
  {ts}CiviDesk Mailchimp Settings.{/ts}
</div>

{if $rows}
  <div id="setting-list">
    {strip}
    {* handle enable/disable actions *}
      {include file="CRM/common/enableDisable.tpl"}
      {include file="CRM/common/jsortable.tpl"}
      <table id="options" class="display">
        <thead>
        <tr>
          <th id="sortable">{ts}Base Url{/ts}</th>
          <th>{ts}Api Key{/ts}</th>
          <th>{ts}List ID{/ts}</th>
          <th>{ts}Is Active{/ts}</th>
          <th></th>
        </tr>
        </thead>
        {foreach from=$rows item=row}
          <tr id="CiviMailchimp_Setting-{$row.id}" class="{$row.class}{if NOT $row.is_active} disabled{/if}">
            <td class="right">{$row.base_url}</td>
            <td class="right">{$row.api_key}</td>
            <td class="right">{$row.list_id}</td>
            <td class="right">{if $row.is_active}Yes{else}No{/if}</td>
            <td>{$row.action|replace:'xx':$row.id}</td>
          </tr>
        {/foreach}
      </table>
    {/strip}

    <div class="action-link">
      <a href='{crmURL p='civicrm/civimailchimp/setting/add' q="reset=1"}' id="newMailchimpSetting"
         class="button"><span>&raquo; {ts}Add Mailchimp Setting{/ts}</span></a>
    </div>
  </div>
{else}
  <div class="messages status no-popup">
    <div class="icon inform-icon"></div>
    {capture assign=crmURL}{crmURL p='civicrm/civimailchimp/setting/add' q="reset=1"}{/capture}
    {ts 1=$crmURL}Mailchimp settings are not configured. You can <a href='%1'>configure one</a>.{/ts}
  </div>
{/if}
