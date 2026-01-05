<?php

/**
 * @var \CodeIgniter\Pager\PagerRenderer $pager
 */
$pager->setSurroundCount(2);
?>

<nav aria-label="<?= lang('Pager.pageNavigation') ?>">
    <ul class="flex items-center justify-center space-x-1">
        <?php if ($pager->hasPrevious()): ?>
            <li>
                <a href="<?= $pager->getFirst() ?>"
                    class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition"
                    aria-label="<?= lang('Pager.first') ?>">
                    <span aria-hidden="true">«</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getPrevious() ?>"
                    class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition"
                    aria-label="<?= lang('Pager.previous') ?>">
                    <span aria-hidden="true">‹</span>
                </a>
            </li>
        <?php endif ?>

        <?php foreach ($pager->links() as $link): ?>
            <li>
                <?php if ($link['active']): ?>
                    <span class="px-3 py-2 rounded-lg bg-blue-600 text-white font-semibold">
                        <?= $link['title'] ?>
                    </span>
                <?php else: ?>
                    <a href="<?= $link['uri'] ?>"
                        class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition">
                        <?= $link['title'] ?>
                    </a>
                <?php endif ?>
            </li>
        <?php endforeach ?>

        <?php if ($pager->hasNext()): ?>
            <li>
                <a href="<?= $pager->getNext() ?>"
                    class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition"
                    aria-label="<?= lang('Pager.next') ?>">
                    <span aria-hidden="true">›</span>
                </a>
            </li>
            <li>
                <a href="<?= $pager->getLast() ?>"
                    class="px-3 py-2 rounded-lg border border-gray-300 bg-white text-gray-700 hover:bg-gray-50 transition"
                    aria-label="<?= lang('Pager.last') ?>">
                    <span aria-hidden="true">»</span>
                </a>
            </li>
        <?php endif ?>
    </ul>
</nav>