<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly ?>
<?php if (!empty ($attributes)) :?>
    <div class="wpsm-table wpsm-icecat-spec">
        <table>
            <?php foreach ($attributes as $key=>$feature): ?>
                <tr>
                    <td class="icecat-spec-val">
                        <?php echo esc_html($feature['name']) ?>
                    </td>
                    <td>
                        <?php echo esc_html($feature['value']) ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table> 
    </div>
<?php endif ;?>