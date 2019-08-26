<?php

require_once 'campaigntags.civix.php';

/**
 * Implements hook_civicrm_config().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_config
 */
function campaigntags_civicrm_config(&$config) {
  _campaigntags_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 *
 * @param array $files
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_xmlMenu
 */
function campaigntags_civicrm_xmlMenu(&$files) {
  _campaigntags_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_install
 */
function campaigntags_civicrm_install() {
  _campaigntags_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_uninstall
 */
function campaigntags_civicrm_uninstall() {
  //TODO delete the option value
  //TODO delete the tags for campaigns?
  //TODO delete the entity tags?
  _campaigntags_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_enable
 */
function campaigntags_civicrm_enable() {
  // Create new option value for the group 'tag_used_for'
  $group = civicrm_api('option_group', 'getsingle', array('version' => 3, 'name' => 'tag_used_for'));
  $group_id = $group['id'];
  $value = civicrm_api('option_value', 'getsingle', array('version' => 3, 'option_group_id' => $group_id, 'value' => 'civicrm_campaign'));
  if (isset($value['is_error']) && $value['is_error']) {
    $params = array(
      'version' => 3,
      'sequential' => 1,
      'option_group_id' => $group_id,
      'name' => 'Campaigns',
      'label' => 'Campaigns',
      'value' => 'civicrm_campaign',
      'weight' => 5,
      'is_active' => 1,
    );
    civicrm_api('option_value', 'create', $params);
  } else if (!$value['is_active']) {
    $params = array(
      'version' => 3,
      'sequential' => 1,
      'id' => $value['id'],
      'is_active' => 1,
    );
    civicrm_api('option_value', 'create', $params);
  }
  _campaigntags_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_disable
 */
function campaigntags_civicrm_disable() {
  _campaigntags_civix_civicrm_disable();
  $group = civicrm_api('option_group', 'getsingle', array('version' => 3, 'name' => 'tag_used_for'));
  $group_id = $group['id'];
  $value = civicrm_api('option_value', 'getsingle', array('version' => 3, 'option_group_id' => $group_id, 'value' => 'civicrm_campaign'));
  if (isset($value['id'])) {
    $params = array(
      'version' => 3,
      'sequential' => 1,
      'id' => $value['id'],
      'is_active' => 0,
    );
    civicrm_api('option_value', 'create', $params);
  }
}

/**
 * Implements hook_civicrm_upgrade().
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed
 *   Based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_upgrade
 */
function campaigntags_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _campaigntags_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_managed
 */
function campaigntags_civicrm_managed(&$entities) {
  _campaigntags_civix_civicrm_managed($entities);
}

/**
 * Implements hook_civicrm_caseTypes().
 *
 * Generate a list of case-types.
 *
 * @param array $caseTypes
 *
 * Note: This hook only runs in CiviCRM 4.4+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function campaigntags_civicrm_caseTypes(&$caseTypes) {
  _campaigntags_civix_civicrm_caseTypes($caseTypes);
}

/**
 * Implements hook_civicrm_angularModules().
 *
 * Generate a list of Angular modules.
 *
 * Note: This hook only runs in CiviCRM 4.5+. It may
 * use features only available in v4.6+.
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_caseTypes
 */
function campaigntags_civicrm_angularModules(&$angularModules) {
_campaigntags_civix_civicrm_angularModules($angularModules);
}

/**
 * Implements hook_civicrm_alterSettingsFolders().
 *
 * @link http://wiki.civicrm.org/confluence/display/CRMDOC/hook_civicrm_alterSettingsFolders
 */
function campaigntags_civicrm_alterSettingsFolders(&$metaDataFolders = NULL) {
  _campaigntags_civix_civicrm_alterSettingsFolders($metaDataFolders);
}

/**
 * Add a tag selector to the campaign form
 */
function campaigntags_civicrm_buildForm($formName, &$form) {
  if ($formName == 'CRM_Campaign_Form_Campaign') {
    $campaign_id = $form->getVar('_campaignId');

    // Add the tag selector if some campaign tags are available
    $tags = CRM_Core_BAO_Tag::getColorTags('civicrm_campaign');
    if (!empty($tags)) {
      $form->add('select2', 'tag', ts('Tags'), $tags, FALSE, array('class' => 'huge', 'placeholder' => ts('- select -'), 'multiple' => TRUE));
    }
    $parentNames = CRM_Core_BAO_Tag::getTagSet('civicrm_campaign');
    CRM_Core_Form_Tag::buildQuickForm($form, $parentNames, 'civicrm_campaign', $campaign_id);

    // set default tags if editing an existing campaign
    if ($campaign_id) {
      $defaults['tag'] = implode(',', CRM_Core_BAO_EntityTag::getTag($campaign_id, 'civicrm_campaign'));
      $form->setDefaults($defaults);
    }

    // new tag
    // Add the tag selector if some campaign tags are available
    $tags = CRM_Core_BAO_Tag::getColorTags('civicrm_goal_campaign');
    if (!empty($tags)) {
      $form->add('select2', 'taggoals', ts('Tags goals'), $tags, FALSE, array('class' => 'huge', 'placeholder' => ts('- select -'), 'multiple' => TRUE));
    }
    $parentNames = CRM_Core_BAO_Tag::getTagSet('civicrm_goal_campaign');
    CRM_Core_Form_Tag::buildQuickForm($form, $parentNames, 'civicrm_goal_campaign', $campaign_id);

    // set default tags if editing an existing campaign
    if ($campaign_id) {
      $defaults['taggoals'] = implode(',', CRM_Core_BAO_EntityTag::getTag($campaign_id, 'civicrm_goal_campaign'));
      $form->setDefaults($defaults);
    }

    CRM_Core_Region::instance('form-body')->add(array('template' => 'CRM/CampaignTags/Form/CampaignTags.tpl'));

  }
}

/**
 * Saves in session the id of a created campaign, so that it can be access by postProcess hook
 */
function campaigntags_civicrm_post($op, $objectName, $objectId, &$object) {
  if ($op == 'create' && $objectName == 'Campaign') {
    CRM_Core_Session::singleton()->set('_campaigntags_entity_id', $objectId);
  }
}

/**
 * Saves or delete the campaign tags in DB
 * //TODO move the delete to DB post hook
 */
function campaigntags_civicrm_postProcess($formName, &$form) {
  if ($formName == 'CRM_Campaign_Form_Campaign') {
    $campaign_id = $form->getVar('_campaignId');
    if (!$campaign_id) {
      $campaign_id = CRM_Core_Session::singleton()->get('_campaigntags_entity_id');
    }

    if ($campaign_id) {
      if ($form->getAction() == CRM_Core_Action::DELETE) {
        // delete tags for the entity
        $tagParams = array(
          'entity_table' => 'civicrm_campaign',
          'entity_id' => $campaign_id,
        );
        CRM_Core_BAO_EntityTag::del($tagParams);
      }
      else {
        //Save the campaign tags
        $tagParams = array();
        $params = $form->controller->exportValues($form->getVar('_name'));
        if (!empty($params['tag'])) {
          if (!is_array($params['tag'])) {
            $params['tag'] = explode(',', $params['tag']);
          }
          foreach ($params['tag'] as $tag) {
            $tagParams[$tag] = 1;
          }
        }
        CRM_Core_BAO_EntityTag::create($tagParams, 'civicrm_campaign', $campaign_id);

        $tagGoalsParams = [];
        if (!empty($params['taggoals'])) {
          if (!is_array($params['taggoals'])) {
            $params['taggoals'] = explode(',', $params['taggoals']);
          }
          foreach ($params['taggoals'] as $tag) {
            $tagGoalsParams[$tag] = 1;
          }
        }
        CRM_Core_BAO_EntityTag::create($tagGoalsParams, 'civicrm_goal_campaign', $campaign_id);
      }
    }
  }
}
