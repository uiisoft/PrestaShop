<?php
/**
 * Copyright since 2007 PrestaShop SA and Contributors
 * PrestaShop is an International Registered Trademark & Property of PrestaShop SA
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.md.
 * It is also available through the world-wide-web at this URL:
 * https://opensource.org/licenses/OSL-3.0
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@prestashop.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
 * versions in the future. If you wish to customize PrestaShop for your
 * needs please refer to https://devdocs.prestashop.com/ for more information.
 *
 * @author    PrestaShop SA and Contributors <contact@prestashop.com>
 * @copyright Since 2007 PrestaShop SA and Contributors
 * @license   https://opensource.org/licenses/OSL-3.0 Open Software License (OSL 3.0)
 */

declare(strict_types=1);

namespace Tests\Integration\Behaviour\Features\Context\Domain\Product;

use PrestaShop\PrestaShop\Core\Domain\Product\Command\AssociateProductAttachmentCommand;
use PrestaShop\PrestaShop\Core\Domain\Product\Command\SetAssociatedProductAttachmentsCommand;
use Tests\Integration\Behaviour\Features\Context\Domain\AbstractDomainFeatureContext;
use Tests\Integration\Behaviour\Features\Context\Util\PrimitiveUtils;

class UpdateAttachmentFeatureContext extends AbstractDomainFeatureContext
{
    /**
     * @When I associate attachment :attachmentReference with product :productReference
     *
     * @param string $attachmentReference
     * @param string $productReference
     */
    public function associateProductAttachment(string $attachmentReference, string $productReference): void
    {
        $this->getCommandBus()->handle(new AssociateProductAttachmentCommand(
            $this->getSharedStorage()->get($productReference),
            $this->getSharedStorage()->get($attachmentReference)
        ));
    }

    /**
     * @When I associate product :productReference with following attachments: :attachmentReferences
     *
     * @param string $productReference
     * @param string $attachmentReferences
     */
    public function setAssociatedProductAttachments(string $productReference, string $attachmentReferences): void
    {
        $attachmentIds = [];

        foreach (PrimitiveUtils::castStringArrayIntoArray($attachmentReferences) as $attachmentReference) {
            $attachmentIds[] = $this->getSharedStorage()->get($attachmentReference);
        }

        $this->getCommandBus()->handle(new SetAssociatedProductAttachmentsCommand(
            $this->getSharedStorage()->get($productReference),
            $attachmentIds
        ));
    }
}
