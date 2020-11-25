<?php
/* Smarty version 3.1.34-dev-7, created on 2020-10-27 15:32:03
  from 'wiki:FormEdit' */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.34-dev-7',
  'unifunc' => 'content_5f982f636afed3_31581302',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '4d8aa6d35369efc1a9fae4acbca65fd261327301' => 
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
function content_5f982f636afed3_31581302 (Smarty_Internal_Template $_smarty_tpl) {
?><a href="./<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['link']->value, ENT_QUOTES, 'UTF-8', true);?>
?action=formedit" target="_self"><?php echo htmlspecialchars($_smarty_tpl->tpl_vars['label']->value, ENT_QUOTES, 'UTF-8', true);?>
</a><?php }
}
