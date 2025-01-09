<?php if (isset($component)) { $__componentOriginalb525200bfa976483b4eaa0b7685c6e24 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-widgets::components.widget','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament-widgets::widget'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <?php if (isset($component)) { $__componentOriginalee08b1367eba38734199cf7829b1d1e9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalee08b1367eba38734199cf7829b1d1e9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.section.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('filament::section'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <style>
            .pagination nav>div {
                flex-direction: column !important;
                justify-content: center !important;
                align-items: center !important;
                width: 100%;
                gap: 10px
            }
        </style>
        <div class="space-y-4" wire:poll.5000ms>
            <div class="overflow-y-auto max-h-[500px] rounded-lg">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $this->getRequests(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $request): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="py-4 flex gap-6 border-b" style="border-color: rgba(128, 128, 128, 0.185)">
                        <!-- User Image -->
                        <div class="relative"
                            style="display: flex;flex-direction: column;align-items: center; gap: 10px; width: 120px">
                            <img src="<?php echo e($request->user->picture ?? asset('images/default_user.jpg')); ?>" alt="User Image"
                                class="w-20 h-20 rounded-lg object-cover">
                            <span
                                style="background-color: <?php echo e(match ($request->status) {
                                    1 => '#dfb200',
                                    2 => '#0062df',
                                    3 => '#34b704',
                                    4 => '#c8222c',
                                    default => '#dfb200',
                                }); ?>; padding: 5px; border-radius: 5px; color: white;">
                                <?php echo e(match ($request->status) {
                                    1 => 'Pending',
                                    2 => 'Confirmed',
                                    3 => 'Completed',
                                    4 => 'Uncompleted',
                                    default => 'Undefined',
                                }); ?>

                            </span>
                        </div>

                        <!-- Request Details -->
                        <div class="flex-1 space-y-2">
                            <!--[if BLOCK]><![endif]--><?php if($request->booking_details->type === 'hotel'): ?>
                                <h4 class="text-lg font-bold">Hotel: <?php echo e($request->booking_details->hotel); ?></h4>
                                <p>Room: <?php echo e($request->booking_details->room); ?></p>
                                <p>Persons: <?php echo e($request->booking_details->persons); ?></p>
                            <?php elseif($request->booking_details->type === 'tour'): ?>
                                <h4 class="text-lg font-bold">Tour: <?php echo e($request->booking_details->tour); ?></h4>
                                <p>Package: <?php echo e($request->booking_details->package); ?></p>
                                <p>Persons: <?php echo e($request->booking_details->persons); ?></p>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                            <p>Phone: <?php echo e($request->booking_details->phone); ?></p>
                            <p>Email: <?php echo e($request->user->email); ?></p>
                        </div>
                        <div style="width: 80px;display: flex;flex-direction: column;gap: 16px; align-items: center;">
                            <!--[if BLOCK]><![endif]--><?php if($request->status != 3 && $request->status != 4): ?>
                                <button wire:click="approve(<?php echo e($request->id); ?>)"
                                    class="px-3 py-1 bg-green-500 text-white rounded-md"
                                    style="background-color: #56c822">
                                    <?php echo e(match ($request->status) {
                                        1 => 'Confirm',
                                        2 => 'Complete',
                                        default => 'Undefined',
                                    }); ?>


                                </button>
                                <button wire:click="cancel(<?php echo e($request->id); ?>)"
                                    class="px-3 py-1 bg-red-500 text-white rounded-md"
                                    style="background-color: #c8222c">
                                    Cancel
                                </button>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>

            <!-- Pagination Controls -->
            <div class="mt-4 pagination">
                <?php echo e($this->getRequests()->links()); ?>

            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $attributes = $__attributesOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__attributesOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalee08b1367eba38734199cf7829b1d1e9)): ?>
<?php $component = $__componentOriginalee08b1367eba38734199cf7829b1d1e9; ?>
<?php unset($__componentOriginalee08b1367eba38734199cf7829b1d1e9); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $attributes = $__attributesOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__attributesOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24)): ?>
<?php $component = $__componentOriginalb525200bfa976483b4eaa0b7685c6e24; ?>
<?php unset($__componentOriginalb525200bfa976483b4eaa0b7685c6e24); ?>
<?php endif; ?>
<?php /**PATH /mnt/data/sphinx-travel/dashboard/resources/views/filament/widgets/requests-widget.blade.php ENDPATH**/ ?>