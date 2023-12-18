<?php
namespace Drupal\bouquet\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Database\Database;

/**
 * privides a block with sample text
 * 
 * @Block(
 * id = "sample_bouquet_block",
 * admin_label = @Translation("Sample Bouquet Block")
 * )
 */
class BouquetBlock extends BlockBase{

    /**
     * {@inheritdoc }
     */
    public function build(){

        $database = Database::getConnection();

        $query = $database->select('bouquet', 'n');
        $query->addField('n', 'name');
        $result = $query->execute()->fetchCol();

        // dpm($result);

        return[
            '#type' => 'markup',
            '#markup' => 'sdfsdf',
        ];
    }

    //what is the use of this hook, how to check this hook functionality ?
    function bouquet_block_view_system_menu_block_alter(array &$build, BlockPluginInterface $block) {
        // Add contextual links for system menu blocks.
        $menus = menu_list_system_menus();
        dpm($menus);
        \Drupal::messenger()->addMessage('block menus', 'menus');
        $menu_name = $block->getDerivativeId();
        if (isset($menus[$menu_name])) {
          $build['#contextual_links']['menu'] = [
            'route_parameters' => array('menu' => $menu_name),
          ];
        }
      }

}