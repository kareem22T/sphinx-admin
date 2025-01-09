<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="card w-full" style="height: calc(100%);" wire:poll.5s>
        <div class="card-header p-4 rounded-t-lg flex justify-between items-center"
            style="background: rgba(var(--gray-900),var(--tw-bg-opacity,1)); margin-bottom: 32px;border-radius: 10px">
            <div class="flex items-center gap-4">
                <img class="w-12 h-12 rounded-full object-cover"
                    src="<?php echo e($chat->join_type === 'Google' ? $chat->picture : ($chat->picture ? asset($chat->picture) : asset('images/avatar/default_user.jpg'))); ?>"
                    alt="<?php echo e($chat->name); ?>">
                <div>
                    <h4 class="text-lg font-bold"><?php echo e($chat->name); ?></h4>
                    <p class="text-sm"><?php echo e($chat->phone ?? $chat->email); ?></p>
                </div>
            </div>
        </div>

        <div class="card-body overflow-auto" id="msg_container" style="height: 100%;max-height: 400px">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $chat->messages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="mb-4 <?php echo e($message->is_user_sender ? 'text-left' : 'text-right'); ?>">
                    <div class="inline-block p-3 rounded-full"
                        style="background: <?php echo e($message->is_user_sender ? '#eee' : '#0e026d'); ?>; color: <?php echo e($message->is_user_sender ? '#000' : '#fff'); ?>;">
                        <?php echo e($message->msg); ?>

                    </div>
                    <span class="text-xs block mt-1">
                        <?php echo e($message->created_at->diffForHumans()); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <div class="card-footer p-4 flex gap-4">
            <textarea class="form-control rounded flex-1" style="color: #000;resize: none" wire:model.defer="currentMessage"
                placeholder="Type your message..."></textarea>
            <button class="btn btn-primary" wire:click="sendMessage"
                style="background: #0062df; padding: 8px 40px">Send</button>
        </div>
    </div>

    <script>
        const container = document.getElementById('msg_container');
        container.scrollTop = container.scrollHeight;
    </script>

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php /**PATH /mnt/data/sphinx-travel/dashboard/resources/views/filament/pages/chat.blade.php ENDPATH**/ ?>