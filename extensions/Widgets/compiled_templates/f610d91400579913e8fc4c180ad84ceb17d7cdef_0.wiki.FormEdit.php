<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-29 08:42:12
  from 'wiki:FormEdit' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f9a7254a3a707_44748838',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    'f610d91400579913e8fc4c180ad84ceb17d7cdef' => 
    array (
      0 => 'wiki:FormEdit',
      1 => 20200812091327,
      2 => 'wiki',
    ),
  ),
  'includes' => 
  array (
  ),
),false)) {
function content_5f9a7254a3a707_44748838 (Smarty_Internal_Template $_smarty_tpl) {
?><a href="./<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value, ENT_QUOTES, 'UTF-8', true);?>
?action=formedit" target="_self"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label']->value, ENT_QUOTES, 'UTF-8', true);?>
</a><?php }
}
