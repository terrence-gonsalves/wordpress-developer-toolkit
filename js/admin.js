function wpdt_delete_plugin(id)
{
  jQuery('#delete_plugin').val(id);
  document.delete_plugin_form.submit();
}
