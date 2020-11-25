<?php
/* Smarty version 3.1.34-dev-7, created on 2020-11-25 09:31:02
  from 'wiki:BTN Form Edit' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5fbe1646d1c225_78886959',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3a8c353f51c99fb6dff8707acd635ed0afac99b9' => 
    array (
      0 => 'wiki:BTN Form Edit',
      1 => 20201029105431,
      2 => 'wiki',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5fbe1646d1c225_78886959 (Smarty_Internal_Template $_smarty_tpl) {
?><a href="<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['server']->value, ENT_QUOTES, 'UTF-8', true);
echo htmlspecialchars($_smarty_tpl->tpl_vars['scriptpath']->value, ENT_QUOTES, 'UTF-8', true);?>
/index.php/<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['fullpagename']->value, ENT_QUOTES, 'UTF-8', true);?>
?action=formedit" target="_self"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label']->value, ENT_QUOTES, 'UTF-8', true);?>
</a><?php }
}
