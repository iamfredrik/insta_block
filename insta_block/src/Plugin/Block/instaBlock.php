<?php
namespace Drupal\insta_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a Instagram Block
 *
 * @Block(
 *   id = "insta_block",
 *   admin_label = @Translation("insta block"),
 * )
 */
class instaBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {
    $config = $this->getConfiguration();

    if (!empty($config['page_name'])) {
      $page_name = $config['page_name'];
    }
    else {
      $page_name = $this->t('not defined');
    }
    if (!empty($config['sm_columns'])) {
      $sm_columns = $config['sm_columns'];
    }
    else {
      $sm_columns = 0;
    }
    if (!empty($config['md_columns'])) {
      $md_columns = $config['md_columns'];
    }
    else {
      $md_columns = 0;
    }
    if (!empty($config['lg_columns'])) {
      $lg_columns = $config['lg_columns'];
    }
    else {
      $lg_columns = 0;
    }
    if (!empty($config['count'])) {
      $count = $config['count'];
    }
    else {
      $count = 0;
    }
    if (!empty($config['show_caption'])) {
      $show_caption = $config['show_caption'];
    }
    else {
      $show_caption = 0;
    }


    return array(
      '#theme' => 'insta_block',
      '#title' => $this->t('Instagram feed'),
      '#attached' => array(
        'library' => array(
          'insta_block/insta-posts'
        ),
        'drupalSettings' => array(
          'insta_block' => array(
            'instagramPosts' => array(
              'page_name' => $page_name,
              'sm_columns' => $sm_columns,
              'md_columns' => $md_columns,
              'lg_columns' => $lg_columns,
              'count' => $count,
              'show_caption' => $show_caption,
            ),
          ),
        ),
      ),
    );

  }

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    $default_config = \Drupal::config('insta_block.settings');
    return array(
      'page_name' => $default_config->get('insta.page_name'),
      'sm_columns' => $default_config->get('insta.sm_columns'),
      'md_columns' => $default_config->get('insta.md_columns'),
      'lg_columns' => $default_config->get('insta.lg_columns'),
      'count' => $default_config->get('insta.count'),
    );
  }


  /**
   * {@inheritdoc}
   */
  public function blockForm($form, FormStateInterface $form_state) {
   $form = parent::blockForm($form, $form_state);

    $config = $this->getConfiguration();

    $form['insta_page_name'] = array(
      '#type' => 'textfield',
      '#title' => $this->t('Instagram Account Name'),
      '#description' => $this->t('The name or ID of the Instagram page'),
      '#default_value' => isset($config['page_name']) ? $config['page_name'] : '',
    );

    $form['insta_posts_count'] = array(
      '#type' => 'number',
      '#title' => $this->t('Number of Posts'),
      '#default_value' => isset($config['count']) ? $config['count'] : '',
      '#min' => 0,
      '#max' => 50, 
    );

    $form['insta_sm_column_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Select number of columns for small devices (tablets, 768px and up)'),
      '#options' => [
        '0' => $this->t('None'),
        '1' => $this->t('One'),
        '2' => $this->t('Two'),
        '3' => $this->t('Three'),
        '4' => $this->t('Four'),
      ],
      '#default_value' => isset($config['sm_columns']) ? $config['sm_columns'] : '',
    ];

    $form['insta_md_column_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Select number of columns for medium devices (desktops, 992px and up)'),
      '#options' => [
        '0' => $this->t('None'),
        '1' => $this->t('One'),
        '2' => $this->t('Two'),
        '3' => $this->t('Three'),
        '4' => $this->t('Four'),
      ],
      '#default_value' => isset($config['md_columns']) ? $config['md_columns'] : '',
    ];

    $form['insta_lg_column_select'] = [
      '#type' => 'select',
      '#title' => $this->t('Select number of columns for large devices (large desktops, 1200px and up)'),
      '#options' => [
        '0' => $this->t('None'),
        '1' => $this->t('One'),
        '2' => $this->t('Two'),
        '3' => $this->t('Three'),
        '4' => $this->t('Four'),
        '6' => $this->t('Six'),
      ],
      '#default_value' => isset($config['lg_columns']) ? $config['lg_columns'] : '',
    ];

    $form['insta_show_caption'] = array(
      '#type' => 'checkbox',
      '#title' => $this->t('Show caption'),
      '#description' => $this->t('Show caption under the image'),
      '#return_value' => 1,
      '#default_value' => isset($config['show_caption']) ? $config['show_caption'] : '',
    );

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function blockSubmit($form, FormStateInterface $form_state) {
     $this->configuration['page_name'] = $form_state->getValue('insta_page_name');
     $this->configuration['sm_columns'] = $form_state->getValue('insta_sm_column_select');
     $this->configuration['md_columns'] = $form_state->getValue('insta_md_column_select');
     $this->configuration['lg_columns'] = $form_state->getValue('insta_lg_column_select');
     $this->configuration['count'] = $form_state->getValue('insta_posts_count');
     $this->configuration['show_caption'] = $form_state->getValue('insta_show_caption');
  }
}