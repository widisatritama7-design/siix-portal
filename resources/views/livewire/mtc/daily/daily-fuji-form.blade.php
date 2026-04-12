<div>
    <flux:modal name="daily-fuji-form-modal" class="max-w-4xl" wire:ignore.self>
        <div class="space-y-4">
            <div class="flex justify-between items-center border-b border-zinc-200 dark:border-zinc-700 pb-3">
                <h3 class="text-lg font-semibold text-zinc-900 dark:text-white">
                    {{ $isEdit ? 'Edit' : 'Create' }} Daily Fuji Inspection
                </h3>
                <flux:button 
                    wire:click="$dispatch('close-modal', 'daily-fuji-form-modal')" 
                    icon="x-mark" 
                    variant="subtle"
                    size="sm"
                />
            </div>
            
            <div class="space-y-4 max-h-[75vh] overflow-y-auto px-1 pb-4">
                <!-- Header Info -->
                <div class="grid grid-cols-2 gap-4 p-4 bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-950/30 dark:to-indigo-950/30 rounded-lg">
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Line Number</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ $masterLine->line_number ?? 'N/A' }}
                        </p>
                    </div>
                    <div>
                        <label class="text-xs font-medium text-zinc-500">Machine Type</label>
                        <p class="text-sm font-semibold text-zinc-900 dark:text-white">
                            {{ ucfirst($masterLine->machine_type ?? 'N/A') }}
                        </p>
                    </div>
                </div>

                <!-- STEP 1: GENERAL -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">1</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">GENERAL</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Body Cover</label>
                            <p class="text-xs text-zinc-500">Details On Check : Make sure all machine cover clean | Standard : No Dust and clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="body_cover" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="body_cover" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 2: LOADER -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">2</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">LOADER</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (1)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Operation And center | Standard : Smooth and center</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cylinder" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cylinder" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (1.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="rail_and_magazine_pcb" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="rail_and_magazine_pcb" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (1.b)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cover_magazine" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cover_magazine" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 3: PCB CLEANER -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">3</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">PCB CLEANER</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Brush (2)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning touch PCB | Standard : Rotation</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="brush" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="brush" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (2.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.45 - 0.54 Mpa</p>
                            <input type="text" wire:model="air_presure" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Unitech (2.b)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.45 - 0.54 Mpa (Unitech only)</p>
                            <input type="text" wire:model="vacume_presure_unitech" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Pressure Nix (2.c)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.60 - 0.70 Mpa (N.I.X only)</p>
                            <input type="text" wire:model="vacume_presure_nix" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vacume Brush (3)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Operation | Standard : Rotation</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="vacume_brush" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="vacume_brush" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Roller (4)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Rotation and Cleaning | Standard : Smooth rotation & Clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cleaning_roller" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cleaning_roller" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Ionizer (5)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning | Standard : 5 Times to push cleaner</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="ionizer" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="ionizer" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Conveyor Setting (6)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Analog panel (write value) | Standard : 40</p>
                            <input type="text" wire:model="conveyor_speed" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- STEP 4: PRINTING -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">4</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">PRINTING</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">IPA Solvent (7)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Make sure solvent minimal on mid level (half) | Standard : Tank Minimal half</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="ipa_solvent" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="ipa_solvent" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (8)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Result-01 | Standard : 23-27℃</p>
                            <input type="text" wire:model="temperature_control_1" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Humidity Control (8.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Result-01 | Standard : 35 % - 70 %</p>
                            <input type="text" wire:model="humidity_control_1" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Clamp Pressure (9)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.20 ~ 0.4 Mpa</p>
                            <input type="text" wire:model="clamp_presure" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Squeege Upper (10)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.12 ~ (+/ 0.01) Mpa</p>
                            <input type="text" wire:model="squeege_upper" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cleaning Solvent (11)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.20 ~ (+/ 0.01) Mpa</p>
                            <input type="text" wire:model="cleaning_solvent" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter (12)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.50~ 0.55 Mpa</p>
                            <input type="text" wire:model="air_presure_meter" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- STEP 5: SPI -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">5</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">SPI</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Meter Parmi (12.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa (PARMI)</p>
                            <input type="text" wire:model="air_presure_meter_parmi" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Capability Index (12.b)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check SPI Measurement result with Master Jig (Solder Paste height) (write CpK value) | Standard : CpK for Masspro > 1.67</p>
                            <input type="text" wire:model="capability_index" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- STEP 6: CHIP MOUNTER 1 -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">6</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">CHIP MOUNTER 1</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (13)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.49 ~ 0.54 Mpa</p>
                            <input type="text" wire:model="air_presure_supply" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (13.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                            <input type="text" wire:model="vaccuum_pump_1" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (13.b)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Chip collection | Standard : No components</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="box_1" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="box_1" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (13.c)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with machine parameter result | Standard : No Yellow initial (display)</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="vaccuum_parameter_1" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="vaccuum_parameter_1" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (14)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Make sure due date on the label | Standard : No Expired</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="expire_date_1" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="expire_date_1" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 7: CHIP MOUNTER 2 -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">7</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">CHIP MOUNTER 2</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure Supply (15)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.49 ~ 0.54 Mpa</p>
                            <input type="text" wire:model="air_presure_supply_2" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Pump (15.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : -87 ~ -100 Kpa</p>
                            <input type="text" wire:model="vaccuum_pump_2" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Box (15.b)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Chip collection | Standard : No components</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="box_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="box_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Vaccuum Parameter (15.c)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with machine parameter result | Standard : No Yellow initial (display)</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="vaccuum_parameter_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="vaccuum_parameter_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Expire Date (16)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Make sure due date on the label | Standard : No Expired</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="expire_date_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="expire_date_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 8: REFLOW -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">8</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">REFLOW</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Abandonment (17)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Damage | Standard : No Damage</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="abandonment" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="abandonment" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (17.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : PCB input area No paper,plastic | Standard : No Paper, No plastic</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fire_posibilty" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fire_posibilty" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Transfer Unit (18)</label>
                            <p class="text-xs text-zinc-500">Details On Check : make sure it is smooth condition | Standard : No jammed</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="rail_and_transfer_unit" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="rail_and_transfer_unit" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">N2 Pressure (19)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check N2 Pressure | Standard : 0.4MPa ~ 0.5MPa</p>
                            <input type="text" wire:model="n2_presure" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density SEK (20)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Oxygen meter (SEK Standard) | Standard : 1200~1800 ppm</p>
                            <input type="text" wire:model="oxygent_density_sek" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Oxygen Density Special (20)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Oxygen meter (Special Requirement) | Standard : 500~1000 ppm</p>
                            <input type="text" wire:model="oxygent_density_special" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fire Possibility (20.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : PCB Output area No paper,plastic | Standard : No Paper, No plastic</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fire_posibilty_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fire_posibilty_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 9: AOI -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">9</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">AOI</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (20.b)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa</p>
                            <input type="text" wire:model="air_presure_2" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- STEP 10: UNLOADER -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">10</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">UNLOADER</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cylinder (21)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Operation And center | Standard : Smooth and center</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cylinder_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cylinder_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Rail & Magazine PCB (21.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="rail_and_magazine_pcb_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="rail_and_magazine_pcb_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Cover Magazine (21.b)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning Dust and dirty | Standard : No Dust and clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cover_magazine_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="cover_magazine_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 11: AOI TABLE -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">11</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">AOI TABLE</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (22)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning | Standard : No dirt / no dust</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="angle_and_filter" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="angle_and_filter" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Lamp Indicator (22.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : LED Lamp (Green) | Standard : Function</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="lamp_indicator" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="lamp_indicator" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 12: REFLOW 2 -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">12</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">REFLOW 2</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Chiller (23)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Write down the value | Standard : 17-23℃</p>
                            <input type="text" wire:model="temperature_chiller" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (24)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check Value inspect | Standard : 300℃ ±10℃</p>
                            <input type="text" wire:model="temperature_control_3" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- STEP 13: CHIP MOUNTER 3 -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">13</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">CHIP MOUNTER 3</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fan Unit 1 (25)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Make sure all Fan clean | Standard : Clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fan_unit_1" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fan_unit_1" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 14: CHIP MOUNTER 4 -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">14</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">CHIP MOUNTER 4</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Fan Unit 2 (26)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Make sure all Fan clean | Standard : Clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fan_unit_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="fan_unit_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 15: SPI 2 -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">15</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">SPI 2</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Air Pressure (27)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Check with Pressure Meter (write value) | Standard : 0.40 - 0.50 Mpa (Kohyoung)</p>
                            <input type="text" wire:model="air_presure_3" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                    </div>
                </div>

                <!-- STEP 16: PRINTER -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">16</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">PRINTER</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Temperature Control (28)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Air cond Setting Temperature | Standard : 23-27℃</p>
                            <input type="text" wire:model="temperature_control_4" placeholder="Enter value or '-' for not applicable" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Water Reservoirs (28.a)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Damage, Function | Standard : Function, No Damage</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="water_reservoirs" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="water_reservoirs" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 17: PCB CLEANER 2 -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">17</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">PCB CLEANER 2</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Filter (29)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning | Standard : Clean</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="filter" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="filter" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- STEP 18: IONIZER -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">18</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">IONIZER</h4>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Angle & Filter (30)</label>
                            <p class="text-xs text-zinc-500">Details On Check : Cleaning | Standard : No dirt / no dust</p>
                            <div class="flex gap-4 mt-2">
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="angle_and_filter_2" value="checked" class="rounded border-zinc-300">
                                    <span class="text-sm">Checked</span>
                                </label>
                                <label class="inline-flex items-center gap-2">
                                    <input type="radio" wire:model="angle_and_filter_2" value="na" class="rounded border-zinc-300">
                                    <span class="text-sm">- (N/A)</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- TIME & STATUS -->
                <div class="border border-zinc-200 dark:border-zinc-700 rounded-lg overflow-hidden">
                    <div class="bg-blue-100 dark:bg-blue-900/30 px-4 py-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-white dark:bg-zinc-800 text-sm font-bold text-blue-600">19</span>
                            <h4 class="font-semibold text-blue-800 dark:text-blue-300">TIME & STATUS</h4>
                        </div>
                    </div>
                    <div class="p-4 space-y-4">
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Stop Time</label>
                            <input type="time" wire:model="stop_time" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Run Time</label>
                            <input type="time" wire:model="run_time" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                        </div>
                        
                        <div class="space-y-2">
                            <label class="text-sm font-medium text-zinc-700 dark:text-zinc-300">Group</label>
                            <select wire:model="group" class="mt-1 w-full rounded-lg border-zinc-300 dark:border-zinc-700 bg-white dark:bg-zinc-800 px-3 py-2 text-sm">
                                <option value="">Select Group</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="flex justify-end gap-3 pt-3 border-t border-zinc-200 dark:border-zinc-700">
                <flux:button wire:click="$dispatch('close-modal', 'daily-fuji-form-modal')" variant="subtle">
                    Cancel
                </flux:button>
                <flux:button wire:click="save" variant="primary" color="green">
                    {{ $isEdit ? 'Update' : 'Create' }}
                </flux:button>
            </div>
        </div>
    </flux:modal>
</div>