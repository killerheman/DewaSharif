<div class="col-12 mt-4">
    <hr>
    <h5 class="fw-bold text-success mb-3"><i class="bi bi-cpu-fill me-2"></i> Key Capabilities Section</h5>
</div>

<div class="col-md-12 mb-3">
    <label class="form-label fw-semibold">Key Capabilities Section Heading</label>
    <input type="text" name="key_capabilities_heading" class="form-control" placeholder="Key Capabilities" 
           value="{{ old('key_capabilities_heading', $item->key_capabilities_heading ?? 'Key Capabilities') }}">
</div>

<div class="col-12 mb-3">
    <label class="form-label fw-bold">Capability Features / Items (Icons, Headings & Descriptions)</label>
    <div id="capabilities-wrapper">
        @php
            $items = old('key_capabilities_items', $item->key_capabilities_items ?? []);
            if (empty($items) || !is_array($items)) {
                $items = [
                    ['icon' => 'fa-solid fa-bolt', 'heading' => 'Designer/Coder Experience Not Required', 'desc' => 'User friendly, no coding or design experience required'],
                    ['icon' => 'fa-solid fa-shield-halved', 'heading' => 'Device & SEO Friendly', 'desc' => 'Ready for your site SEO, and responsive websites'],
                    ['icon' => 'fa-solid fa-chart-line', 'heading' => 'Flexible and Scalable', 'desc' => 'Easy to build sites on WordPress'],
                    ['icon' => 'fa-solid fa-headset', 'heading' => 'Launch Site in Less Time', 'desc' => 'Launch your website within minutes, not days without stress.']
                ];
            }
        @endphp

        @foreach($items as $index => $cItem)
            @php
                $iconClass = trim($cItem['icon'] ?? 'fa-solid fa-check');
            @endphp
            <div class="card mb-3 p-3 bg-light border capability-row" id="cap-row-{{ $index }}">
                <div class="row align-items-center g-2">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Icon Class</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="{{ $iconClass }}" id="cap-icon-preview-{{ $index }}"></i></span>
                            <input type="text" name="key_capabilities_items[{{ $index }}][icon]" class="form-control" placeholder="e.g. fa-solid fa-bolt" value="{{ $cItem['icon'] ?? '' }}" oninput="updateCapIconPreview(this, 'cap-icon-preview-{{ $index }}')">
                        </div>
                        <small class="text-muted" style="font-size: 0.73rem;">e.g. <code>fa-solid fa-bolt</code>, <code>bi bi-shield-check</code></small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Capability Heading</label>
                        <input type="text" name="key_capabilities_items[{{ $index }}][heading]" class="form-control form-control-sm" placeholder="Capability Heading" value="{{ $cItem['heading'] ?? '' }}">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Short Description</label>
                        <input type="text" name="key_capabilities_items[{{ $index }}][desc]" class="form-control form-control-sm" placeholder="Short description" value="{{ $cItem['desc'] ?? '' }}">
                    </div>
                    <div class="col-md-1 text-end pt-3">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeCapabilityRow({{ $index }})" title="Remove item"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <button type="button" class="btn btn-outline-success btn-sm mt-2" onclick="addCapabilityRow()">
        <i class="bi bi-plus-lg me-1"></i> Add Capability Item
    </button>
</div>

<script>
    let capIndex = {{ count($items) }};

    function updateCapIconPreview(inputEl, previewId) {
        const previewIcon = document.getElementById(previewId);
        if (!previewIcon) return;
        let iconClass = inputEl.value.trim() || 'fa-solid fa-check';
        previewIcon.className = iconClass;
    }

    function addCapabilityRow() {
        const wrapper = document.getElementById('capabilities-wrapper');
        const rowId = 'cap-row-' + capIndex;
        const previewId = 'cap-icon-preview-' + capIndex;
        const html = `
            <div class="card mb-3 p-3 bg-light border capability-row" id="${rowId}">
                <div class="row align-items-center g-2">
                    <div class="col-md-3">
                        <label class="form-label small fw-semibold">Icon Class</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-white"><i class="fa-solid fa-check" id="${previewId}"></i></span>
                            <input type="text" name="key_capabilities_items[${capIndex}][icon]" class="form-control" placeholder="e.g. fa-solid fa-bolt" value="fa-solid fa-check" oninput="updateCapIconPreview(this, '${previewId}')">
                        </div>
                        <small class="text-muted" style="font-size: 0.73rem;">e.g. <code>fa-solid fa-bolt</code>, <code>bi bi-shield-check</code></small>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Capability Heading</label>
                        <input type="text" name="key_capabilities_items[${capIndex}][heading]" class="form-control form-control-sm" placeholder="Capability Heading" value="">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small fw-semibold">Short Description</label>
                        <input type="text" name="key_capabilities_items[${capIndex}][desc]" class="form-control form-control-sm" placeholder="Short description" value="">
                    </div>
                    <div class="col-md-1 text-end pt-3">
                        <button type="button" class="btn btn-outline-danger btn-sm" onclick="removeCapabilityRow(${capIndex})" title="Remove item"><i class="bi bi-trash"></i></button>
                    </div>
                </div>
            </div>
        `;
        wrapper.insertAdjacentHTML('beforeend', html);
        capIndex++;
    }

    function removeCapabilityRow(idx) {
        const row = document.getElementById('cap-row-' + idx);
        if (row) {
            row.remove();
        }
    }
</script>
