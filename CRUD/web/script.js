const ENTITIES = {
	clientes: { label: 'Clientes', pk: ['dni'], fields: ['dni', 'nombre', 'ap1', 'ap2', 'telefono', 'email', 'direccion', 'fecha_renovacion'] },
	pistas: { label: 'Pistas', pk: ['codPista'], fields: ['codPista', 'nombre', 'direccion', 'fecha_mantenimiento'] },
	tarifas: { label: 'Tarifas', pk: ['tarifa'], fields: ['tarifa', 'precio'] },
	karts: { label: 'Karts', pk: ['num_kart'], fields: ['num_kart', 'fecha_mantenimiento'] },
	reservas: { label: 'Reservas', pk: ['num_reserva'], fields: ['num_reserva', 'dni', 'codPista', 'fecha', 'hora_inicio', 'duracion', 'personas', 'tarifa', 'descuento'] },
	carreras: { label: 'Carreras', pk: ['num_carrera'], fields: ['num_carrera', 'codPista', 'num_reserva', 'terminada'] },
	corredores: { label: 'Corredores', pk: ['num_carrera', 'dni'], fields: ['num_carrera', 'dni', 'num_kart', 'posicion'] },
	vueltas: { label: 'Vueltas', pk: ['num_carrera', 'num_kart', 'num_vuelta'], fields: ['num_carrera', 'num_kart', 'num_vuelta', 'tiempo'] }
};

let state = { entity: 'clientes', tab: 'create', photoData: '' };
let stream = null;

const nav = document.getElementById('entityNav');
const form = document.getElementById('crudForm');
const panelTitle = document.getElementById('panelTitle');
const statusBox = document.getElementById('status');
const tableWrap = document.getElementById('tableWrap');
const cameraBox = document.getElementById('cameraBox');
const video = document.getElementById('cameraPreview');
const canvas = document.getElementById('cameraCanvas');
const photoPreview = document.getElementById('photoPreview');

function setStatus(msg, isError = false) {
	statusBox.textContent = msg;
	statusBox.style.color = isError ? '#ef4444' : '#f59e0b';
}

function inputType(field) {
	if (field.includes('fecha')) return 'date';
	if (field.includes('hora') || field === 'tiempo') return 'time';
	if (['precio', 'descuento'].includes(field)) return 'number';
	if (field.startsWith('num_') || ['personas', 'duracion', 'terminada', 'posicion'].includes(field)) return 'number';
	return 'text';
}

function buildField(field, readonly = false) {
	const type = inputType(field);
	return `<div class="field"><label>${field}</label><input name="${field}" type="${type}" ${readonly ? 'readonly' : ''}></div>`;
}

function renderNav() {
	nav.innerHTML = '';
	Object.entries(ENTITIES).forEach(([key, cfg]) => {
		const b = document.createElement('button');
		b.textContent = cfg.label;
		b.className = key === state.entity ? 'active' : '';
		b.onclick = () => {
			state.entity = key;
			state.tab = 'create';
			document.querySelectorAll('.tabs button').forEach(x => x.classList.remove('active'));
			document.querySelector('[data-tab="create"]').classList.add('active');
			render();
		};
		nav.appendChild(b);
	});
}

function renderForm() {
	const cfg = ENTITIES[state.entity];
	panelTitle.textContent = cfg.label;

	let html = '';

	if (state.tab === 'create') {
		html = cfg.fields
			.filter(f => !(state.entity === 'reservas' && f === 'num_reserva') && !(state.entity === 'carreras' && f === 'num_carrera'))
			.map(f => buildField(f))
			.join('');
	} else if (state.tab === 'edit') {
		html = cfg.pk.map(f => buildField(f)).join('') + cfg.fields.filter(f => !cfg.pk.includes(f)).map(f => buildField(f)).join('');
	} else if (state.tab === 'delete') {
		html = cfg.pk.map(f => buildField(f)).join('');
	} else {
		html = '<p style="color:#a1a1aa">Pulsa "Refrescar lista" para cargar datos.</p>';
	}

	form.innerHTML = html;
	tableWrap.classList.toggle('hidden', state.tab !== 'list');
	document.getElementById('submitBtn').textContent = state.tab === 'delete' ? 'Eliminar' : 'Guardar';
	cameraBox.classList.toggle('hidden', !(state.entity === 'clientes' && (state.tab === 'create' || state.tab === 'edit')));
}

function formData() {
	const fd = new FormData();
	const inputs = form.querySelectorAll('input');
	inputs.forEach(i => fd.append(i.name, i.value));
	if (state.entity === 'clientes' && state.photoData) {
		fd.append('foto_data', state.photoData);
	}
	fd.append('entity', state.entity);
	return fd;
}

async function send(action) {
	const fd = formData();
	fd.append('action', action);
	const res = await fetch('api.php', { method: 'POST', body: fd });
	const json = await res.json();
	if (!json.ok) throw new Error(json.error || 'Error');
	return json;
}

async function listRows() {
	const res = await fetch(`api.php?action=list&entity=${state.entity}`);
	const json = await res.json();
	if (!json.ok) throw new Error(json.error || 'Error listando');

	const rows = json.rows;
	if (!rows.length) {
		tableWrap.innerHTML = '<div style="padding:1rem;color:#a1a1aa">Sin registros todavía.</div>';
		return;
	}

	const cols = Object.keys(rows[0]);
	let t = '<table><thead><tr>' + cols.map(c => `<th>${c}</th>`).join('') + '</tr></thead><tbody>';
	rows.forEach(r => {
		t += '<tr>' + cols.map(c => `<td>${r[c] ?? ''}</td>`).join('') + '</tr>';
	});
	t += '</tbody></table>';
	tableWrap.innerHTML = t;
}

function bindTabs() {
	document.querySelectorAll('.tabs button').forEach(btn => {
		btn.onclick = () => {
			document.querySelectorAll('.tabs button').forEach(b => b.classList.remove('active'));
			btn.classList.add('active');
			state.tab = btn.dataset.tab;
			render();
		};
	});
}

async function submitCurrent() {
	try {
		if (state.tab === 'list') {
			await listRows();
			setStatus('Listado actualizado.');
			return;
		}
		const action = state.tab === 'create' ? 'create' : state.tab === 'edit' ? 'update' : 'delete';
		await send(action);
		setStatus('Operación realizada correctamente.');
		if (state.tab === 'list') await listRows();
	} catch (e) {
		setStatus(e.message, true);
	}
}

async function startCamera() {
	if (!navigator.mediaDevices?.getUserMedia) {
		setStatus('Tu navegador no soporta cámara.', true);
		return;
	}
	stream = await navigator.mediaDevices.getUserMedia({ video: true, audio: false });
	video.srcObject = stream;
}

function stopCamera() {
	if (stream) {
		stream.getTracks().forEach(t => t.stop());
		stream = null;
	}
	video.srcObject = null;
}

function takePhoto() {
	const w = video.videoWidth || 320;
	const h = video.videoHeight || 240;
	canvas.width = w;
	canvas.height = h;
	canvas.getContext('2d').drawImage(video, 0, 0, w, h);
	state.photoData = canvas.toDataURL('image/jpeg', 0.9);
	photoPreview.src = state.photoData;
	setStatus('Foto capturada. Se guardará como fotos/$DNI.jpg al crear/editar cliente.');
}

function handleFileUpload(file) {
  if (!file.type.startsWith('image/')) {
    setStatus('Por favor sube una imagen.', true);
    return;
  }
  const reader = new FileReader();
  reader.onload = (e) => {
    state.photoData = e.target.result;
    photoPreview.src = state.photoData;
    setStatus('Imagen cargada. Se guardará como fotos/$DNI.jpg al crear/editar cliente.');
  };
  reader.readAsDataURL(file);
}

document.getElementById('submitBtn').onclick = submitCurrent;
document.getElementById('refreshBtn').onclick = listRows;
document.getElementById('startCamera').onclick = () => startCamera().catch(err => setStatus(err.message, true));
document.getElementById('stopCamera').onclick = stopCamera;
document.getElementById('takePhoto').onclick = takePhoto;

document.getElementById('camTabCamera').onclick = () => {
  document.getElementById('camTabCamera').classList.add('active');
  document.getElementById('camTabUpload').classList.remove('active');
  document.getElementById('cameraMode').classList.remove('hidden');
  document.getElementById('uploadMode').classList.add('hidden');
};

document.getElementById('camTabUpload').onclick = () => {
  document.getElementById('camTabCamera').classList.remove('active');
  document.getElementById('camTabUpload').classList.add('active');
  document.getElementById('cameraMode').classList.add('hidden');
  document.getElementById('uploadMode').classList.remove('hidden');
};

document.getElementById('fileInput').onchange = (e) => {
  const file = e.target.files?.[0];
  if (file) handleFileUpload(file);
};

bindTabs();
render();
