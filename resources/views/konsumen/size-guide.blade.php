@extends('layouts.app')
@section('title','Size Guide')
@section('page_title','Panduan Ukuran')

@section('content')

<div class="page-header">
  <div class="container">
    <h1>Size Guide</h1>
    <p>Panduan lengkap memilih ukuran yang tepat untuk kenyamanan berbelanja Anda</p>
  </div>
</div>

<section class="section">
  <div class="container">

    {{-- Virtual Size Calculator --}}
    <div style="background:linear-gradient(135deg,var(--cream),#F8EFEA);border-radius:24px;padding:48px;margin-bottom:56px;border:1px solid #D4AF37;box-shadow:0 4px 20px rgba(212,175,55,0.1);position:relative;overflow:hidden;">
      <div style="position:absolute;top:-20px;right:-20px;font-size:12rem;opacity:0.05;line-height:1;">📏</div>
      <div style="position:relative;z-index:1;">
        <h2 style="color:var(--primary-dark);margin-bottom:12px;font-size:1.8rem;">Kalkulator Ukuran Virtual</h2>
        <p style="color:var(--gray);margin-bottom:32px;font-size:1.05rem;">Masukkan ukuran Anda (dalam cm) untuk mendapatkan rekomendasi ukuran ideal pakaian Dianca Atelier.</p>
        
        <div style="display:flex;gap:24px;flex-wrap:wrap;align-items:flex-end;">
          <div style="flex:1;min-width:200px;">
            <label class="form-label" style="font-weight:700;color:var(--dark);">Lingkar Dada (cm)</label>
            <input type="number" id="calc-dada" class="form-control" placeholder="Contoh: 85" oninput="calculateSize()" style="border:2px solid var(--cream-dark);border-radius:12px;padding:14px;font-size:1.1rem;">
          </div>
          <div style="flex:1;min-width:200px;">
            <label class="form-label" style="font-weight:700;color:var(--dark);">Lingkar Pinggang (cm)</label>
            <input type="number" id="calc-pinggang" class="form-control" placeholder="Contoh: 70" oninput="calculateSize()" style="border:2px solid var(--cream-dark);border-radius:12px;padding:14px;font-size:1.1rem;">
          </div>
          <div style="flex:1;min-width:200px;">
            <label class="form-label" style="font-weight:700;color:var(--dark);">Lingkar Pinggul (cm)</label>
            <input type="number" id="calc-pinggul" class="form-control" placeholder="Contoh: 94" oninput="calculateSize()" style="border:2px solid var(--cream-dark);border-radius:12px;padding:14px;font-size:1.1rem;">
          </div>
        </div>

        <div id="calc-result" style="margin-top:32px;display:none;background:var(--white);border-radius:16px;padding:24px;border-left:5px solid var(--primary);box-shadow:var(--shadow-sm);">
          <div style="font-size:0.9rem;color:var(--gray);font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:8px;">Rekomendasi Kami</div>
          <div style="display:flex;align-items:center;gap:20px;">
            <div id="calc-size" style="font-size:3rem;font-weight:800;color:var(--primary);line-height:1;"></div>
            <div style="flex:1;">
              <p id="calc-message" style="margin:0;color:var(--dark);font-size:1.05rem;line-height:1.6;"></p>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- Tips Pengukuran --}}
    <div style="background:var(--primary-pale);border-radius:20px;padding:36px;margin-bottom:56px;display:flex;gap:40px;align-items:center;">
      <div style="font-size:5rem;flex-shrink:0;">📏</div>
      <div>
        <h3 style="margin-bottom:12px;color:var(--primary-dark);">Tips Mengukur Tubuh dengan Tepat</h3>
        <div class="grid-2" style="gap:12px;">
          <div style="display:flex;gap:10px;align-items:flex-start;">
            <span style="color:var(--primary);font-weight:700;flex-shrink:0;">1.</span>
            <p style="font-size:0.9rem;color:var(--gray);">Ukur dengan pita ukur yang fleksibel, pastikan tidak terlalu ketat atau longgar.</p>
          </div>
          <div style="display:flex;gap:10px;align-items:flex-start;">
            <span style="color:var(--primary);font-weight:700;flex-shrink:0;">2.</span>
            <p style="font-size:0.9rem;color:var(--gray);">Ukur di atas pakaian tipis atau langsung pada tubuh untuk hasil paling akurat.</p>
          </div>
          <div style="display:flex;gap:10px;align-items:flex-start;">
            <span style="color:var(--primary);font-weight:700;flex-shrink:0;">3.</span>
            <p style="font-size:0.9rem;color:var(--gray);">Berdiri tegak dengan posisi normal saat mengukur.</p>
          </div>
          <div style="display:flex;gap:10px;align-items:flex-start;">
            <span style="color:var(--primary);font-weight:700;flex-shrink:0;">4.</span>
            <p style="font-size:0.9rem;color:var(--gray);">Jika ukuran berada di antara dua size, pilih yang lebih besar untuk kenyamanan.</p>
          </div>
        </div>
      </div>
    </div>

    {{-- Tab navigator --}}
    <div style="display:flex;gap:8px;margin-bottom:32px;border-bottom:2px solid var(--cream-dark);flex-wrap:wrap;">
      @foreach([['Dress & Blouse','dress'],['Celana & Rok','celana'],['Outer & Jaket','outer'],['Aksesoris','aksesori']] as $tab)
      <button onclick="showTab('{{ $tab[1] }}')" id="btn-{{ $tab[1] }}"
              style="padding:12px 24px;border:none;background:none;font-family:'Lato',sans-serif;font-size:0.9rem;font-weight:700;cursor:pointer;color:var(--gray);border-bottom:2px solid transparent;margin-bottom:-2px;transition:all 0.2s;">
        {{ $tab[0] }}
      </button>
      @endforeach
    </div>

    {{-- Dress & Blouse --}}
    <div id="tab-dress" class="size-tab-content">
      <h3 style="margin-bottom:20px;">📏 Tabel Ukuran — Dress & Blouse</h3>
      <div style="overflow-x:auto;border-radius:16px;box-shadow:var(--shadow-sm);">
        <table class="size-table">
          <thead>
            <tr>
              <th>Size</th>
              <th>Lingkar Dada (cm)</th>
              <th>Lingkar Pinggang (cm)</th>
              <th>Lingkar Pinggul (cm)</th>
              <th>Panjang Bahu (cm)</th>
            </tr>
          </thead>
          <tbody>
            <tr><td><strong>XS</strong></td><td>78 – 82</td><td>60 – 64</td><td>84 – 88</td><td>35</td></tr>
            <tr><td><strong>S</strong></td><td>82 – 86</td><td>64 – 68</td><td>88 – 92</td><td>37</td></tr>
            <tr><td><strong>M</strong></td><td>86 – 90</td><td>68 – 72</td><td>92 – 96</td><td>38</td></tr>
            <tr><td><strong>L</strong></td><td>90 – 95</td><td>72 – 77</td><td>96 – 101</td><td>40</td></tr>
            <tr><td><strong>XL</strong></td><td>95 – 100</td><td>77 – 82</td><td>101 – 106</td><td>41</td></tr>
            <tr><td><strong>XXL</strong></td><td>100 – 106</td><td>82 – 88</td><td>106 – 112</td><td>43</td></tr>
          </tbody>
        </table>
      </div>
      <div style="margin-top:20px;background:var(--cream);border-radius:12px;padding:20px;">
        <p style="font-size:0.88rem;color:var(--gray);line-height:1.8;">
          <strong style="color:var(--primary-dark);">💡 Tips:</strong> Untuk dress, ukur lingkar dada pada bagian terlebar. Untuk blouse, prioritaskan ukuran lingkar dada dan bahu.
        </p>
      </div>
    </div>

    {{-- Celana & Rok --}}
    <div id="tab-celana" class="size-tab-content" style="display:none;">
      <h3 style="margin-bottom:20px;">📏 Tabel Ukuran — Celana & Rok</h3>
      <div style="overflow-x:auto;border-radius:16px;box-shadow:var(--shadow-sm);">
        <table class="size-table">
          <thead>
            <tr>
              <th>Size</th>
              <th>Lingkar Pinggang (cm)</th>
              <th>Lingkar Pinggul (cm)</th>
              <th>Panjang Rok (cm)</th>
              <th>Tinggi Badan Ideal</th>
            </tr>
          </thead>
          <tbody>
            <tr><td><strong>XS</strong></td><td>60 – 64</td><td>84 – 88</td><td>70 – 75</td><td>150 – 155 cm</td></tr>
            <tr><td><strong>S</strong></td><td>64 – 68</td><td>88 – 92</td><td>75 – 80</td><td>155 – 160 cm</td></tr>
            <tr><td><strong>M</strong></td><td>68 – 72</td><td>92 – 96</td><td>78 – 82</td><td>158 – 163 cm</td></tr>
            <tr><td><strong>L</strong></td><td>72 – 77</td><td>96 – 101</td><td>80 – 84</td><td>160 – 165 cm</td></tr>
            <tr><td><strong>XL</strong></td><td>77 – 82</td><td>101 – 106</td><td>82 – 86</td><td>163 – 168 cm</td></tr>
            <tr><td><strong>XXL</strong></td><td>82 – 88</td><td>106 – 112</td><td>84 – 88</td><td>165 – 170 cm</td></tr>
          </tbody>
        </table>
      </div>
    </div>

    {{-- Outer & Jaket --}}
    <div id="tab-outer" class="size-tab-content" style="display:none;">
      <h3 style="margin-bottom:20px;">📏 Tabel Ukuran — Outer & Jaket</h3>
      <div style="overflow-x:auto;border-radius:16px;box-shadow:var(--shadow-sm);">
        <table class="size-table">
          <thead>
            <tr>
              <th>Size</th>
              <th>Lingkar Dada (cm)</th>
              <th>Lingkar Pinggang (cm)</th>
              <th>Panjang Bahu (cm)</th>
              <th>Panjang Lengan (cm)</th>
            </tr>
          </thead>
          <tbody>
            <tr><td><strong>XS</strong></td><td>80 – 84</td><td>62 – 66</td><td>36</td><td>56</td></tr>
            <tr><td><strong>S</strong></td><td>84 – 88</td><td>66 – 70</td><td>38</td><td>57</td></tr>
            <tr><td><strong>M</strong></td><td>88 – 92</td><td>70 – 74</td><td>39</td><td>58</td></tr>
            <tr><td><strong>L</strong></td><td>92 – 97</td><td>74 – 79</td><td>41</td><td>59</td></tr>
            <tr><td><strong>XL</strong></td><td>97 – 102</td><td>79 – 84</td><td>42</td><td>60</td></tr>
            <tr><td><strong>XXL</strong></td><td>102 – 108</td><td>84 – 90</td><td>44</td><td>61</td></tr>
          </tbody>
        </table>
      </div>
      <div style="margin-top:20px;background:var(--cream);border-radius:12px;padding:20px;">
        <p style="font-size:0.88rem;color:var(--gray);line-height:1.8;">
          <strong style="color:var(--primary-dark);">💡 Tips:</strong> Untuk outer, pilih satu ukuran lebih besar dari biasanya agar bisa dipakai berlapis di atas blouse/dress.
        </p>
      </div>
    </div>

    {{-- Aksesoris --}}
    <div id="tab-aksesori" class="size-tab-content" style="display:none;">
      <h3 style="margin-bottom:20px;">📏 Panduan Ukuran — Aksesoris</h3>
      <div class="grid-2" style="gap:24px;">
        <div style="background:var(--white);border-radius:16px;padding:28px;box-shadow:var(--shadow-sm);">
          <h4 style="margin-bottom:16px;">💍 Cincin</h4>
          <table class="size-table" style="margin-bottom:0;">
            <thead><tr><th>Ukuran</th><th>Diameter (mm)</th><th>Keliling (mm)</th></tr></thead>
            <tbody>
              <tr><td>5 / XS</td><td>15.7</td><td>49.3</td></tr>
              <tr><td>6 / S</td><td>16.5</td><td>51.9</td></tr>
              <tr><td>7 / M</td><td>17.3</td><td>54.4</td></tr>
              <tr><td>8 / L</td><td>18.2</td><td>57.2</td></tr>
              <tr><td>9 / XL</td><td>19.0</td><td>59.7</td></tr>
            </tbody>
          </table>
        </div>
        <div style="background:var(--white);border-radius:16px;padding:28px;box-shadow:var(--shadow-sm);">
          <h4 style="margin-bottom:16px;">👜 Tas (Perkiraan Dimensi)</h4>
          <table class="size-table" style="margin-bottom:0;">
            <thead><tr><th>Tipe</th><th>Lebar</th><th>Tinggi</th><th>Kedalaman</th></tr></thead>
            <tbody>
              <tr><td>Mini</td><td>15–20 cm</td><td>12–15 cm</td><td>5–8 cm</td></tr>
              <tr><td>Small</td><td>20–25 cm</td><td>15–20 cm</td><td>8–10 cm</td></tr>
              <tr><td>Medium</td><td>25–30 cm</td><td>20–25 cm</td><td>10–12 cm</td></tr>
              <tr><td>Large</td><td>30–40 cm</td><td>25–35 cm</td><td>12–15 cm</td></tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>

    {{-- How to measure --}}
    <div style="margin-top:56px;background:linear-gradient(135deg,var(--black),#2D1A14);border-radius:24px;padding:48px;color:#fff;">
      <div class="section-header" style="margin-bottom:36px;">
        <h2 style="color:#fff;">Cara Mengukur Tubuh</h2>
        <div class="divider-primary"></div>
      </div>
      <div class="grid-3" style="gap:32px;">
        <div style="text-align:center;">
          <div style="font-size:3rem;margin-bottom:16px;">🎀</div>
          <h4 style="color:var(--primary-light);margin-bottom:10px;">Lingkar Dada</h4>
          <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;line-height:1.8;">Ukur melingkar di bagian terlebar dada. Pita ukur harus sejajar lantai dan tidak terlalu ketat.</p>
        </div>
        <div style="text-align:center;">
          <div style="font-size:3rem;margin-bottom:16px;">⭕</div>
          <h4 style="color:var(--primary-light);margin-bottom:10px;">Lingkar Pinggang</h4>
          <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;line-height:1.8;">Ukur pada bagian paling kecil dari pinggang, biasanya 2–3 cm di atas pusar.</p>
        </div>
        <div style="text-align:center;">
          <div style="font-size:3rem;margin-bottom:16px;">🔵</div>
          <h4 style="color:var(--primary-light);margin-bottom:10px;">Lingkar Pinggul</h4>
          <p style="color:rgba(255,255,255,0.6);font-size:0.88rem;line-height:1.8;">Ukur melingkar pada bagian pinggul yang paling besar. Biasanya 18–20 cm di bawah pinggang.</p>
        </div>
      </div>
    </div>

    {{-- Still unsure CTA --}}
    <div style="text-align:center;margin-top:48px;padding:40px;background:var(--cream);border-radius:20px;">
      <div style="font-size:3rem;margin-bottom:16px;">🤔</div>
      <h3 style="margin-bottom:12px;">Masih Ragu dengan Ukuran?</h3>
      <p style="color:var(--gray);margin-bottom:24px;max-width:460px;margin-left:auto;margin-right:auto;">Jangan khawatir! Tim kami siap membantu Anda memilih ukuran yang tepat melalui WhatsApp.</p>
      <a href="https://wa.me/{{ \App\Models\Setting::get('butik_wa','6281234567890') }}?text={{ urlencode('Halo, saya butuh bantuan memilih ukuran yang tepat untuk saya.') }}"
         target="_blank" class="btn btn-wa">💬 Konsultasi Ukuran via WA</a>
    </div>

  </div>
</section>

@push('scripts')
<script>
  function showTab(id) {
    document.querySelectorAll('.size-tab-content').forEach(t => t.style.display = 'none');
    document.querySelectorAll('[id^="btn-"]').forEach(b => {
      b.style.color = 'var(--gray)';
      b.style.borderBottomColor = 'transparent';
    });
    document.getElementById('tab-' + id).style.display = 'block';
    const btn = document.getElementById('btn-' + id);
    if(btn) {
      btn.style.color = 'var(--primary)';
      btn.style.borderBottomColor = 'var(--primary)';
    }
  }
  showTab('dress'); // default tab

  // Size Calculator Logic
  const sizeRules = [
    { name: 'XS', dada: 82, pinggang: 64, pinggul: 88 },
    { name: 'S', dada: 86, pinggang: 68, pinggul: 92 },
    { name: 'M', dada: 90, pinggang: 72, pinggul: 96 },
    { name: 'L', dada: 95, pinggang: 77, pinggul: 101 },
    { name: 'XL', dada: 100, pinggang: 82, pinggul: 106 },
    { name: 'XXL', dada: 106, pinggang: 88, pinggul: 112 }
  ];

  function calculateSize() {
    const dada = parseFloat(document.getElementById('calc-dada').value);
    const pinggang = parseFloat(document.getElementById('calc-pinggang').value);
    const pinggul = parseFloat(document.getElementById('calc-pinggul').value);
    
    if (!dada && !pinggang && !pinggul) {
      document.getElementById('calc-result').style.display = 'none';
      return;
    }

    let recommendedSize = null;
    let sizeIndex = -1;

    // Find the max size category needed to comfortably fit the largest measurement
    sizeRules.forEach((rule, idx) => {
      let fitsDada = !dada || dada <= rule.dada;
      let fitsPinggang = !pinggang || pinggang <= rule.pinggang;
      let fitsPinggul = !pinggul || pinggul <= rule.pinggul;
      
      // We want the smallest size that fits ALL provided measurements
      if (fitsDada && fitsPinggang && fitsPinggul && sizeIndex === -1) {
        sizeIndex = idx;
      }
    });

    const resDiv = document.getElementById('calc-result');
    const resSize = document.getElementById('calc-size');
    const resMsg = document.getElementById('calc-message');

    resDiv.style.display = 'block';

    if (sizeIndex !== -1) {
      recommendedSize = sizeRules[sizeIndex].name;
      resSize.innerText = recommendedSize;
      resMsg.innerHTML = `Berdasarkan ukuran Anda, kami merekomendasikan size <strong>${recommendedSize}</strong>. Jika Anda menyukai pakaian yang lebih longgar, Anda bisa naik satu ukuran (size up).`;
    } else {
      // Exceeds XXL
      resSize.innerText = 'Custom';
      resMsg.innerHTML = `Ukuran Anda berada di luar standar reguler kami. Dianca Atelier menyediakan layanan <strong>Custom Size</strong> agar pakaian pas sempurna di tubuh Anda.`;
    }
  }
</script>
@endpush
@endsection
