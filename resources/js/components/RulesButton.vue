```vue
<template>
  <div dir="rtl">
    <!-- Floating button -->
    <button
      v-if="floating"
      @click="open = true"
      :class="[
        'fixed top-1/2 transform -translate-y-1/2 transition-all duration-700 z-50 cursor-pointer shadow-lg flex items-center justify-center font-bold bg-[#3e4095] text-white ',
        isShrunk
          ? '-left-1 px-4 py-2 rounded-r-xl text-sm opacity-70 hover:left-0 hover:px-6 hover:py-3 hover:text-base hover:text-center hover:opacity-100'
          : 'left-0 px-6 py-3 rounded-r-xl text-base'
      ]"
    >
      <transition name="fade" mode="out-in">
        <span :key="isShrunk ? 'short' : 'full'">
          {{ isShrunk ? 'قوانین' : 'راهنما و قوانین' }}
        </span>
      </transition>
    </button>

    <!-- Non-floating button for bar -->
    <button
      v-else
      @click="open = true"
      class="w-full px-4 py-2 rounded bg-[#3e4095] text-white font-bold text-sm hover:bg-[#3e4095]/90 transition cursor-pointer"
    >
      راهنما و قوانین
    </button>

    <!-- Modal with blurred background -->
    <div
      v-if="open"
      class="fixed inset-0 flex items-center justify-center backdrop-blur-md bg-white/30 z-50"
    >
      <div
        class="bg-white rounded-2xl shadow-2xl max-w-3xl w-11/12 p-6 relative overflow-y-auto max-h-[85vh]"
      >
        <button
          @click="open = false"
          class="absolute top-2 right-3 text-gray-600 hover:text-black text-xl cursor-pointer"
        >
          ✕
        </button>

        <h2 class="text-2xl font-bold mb-4 text-center">
          راهنما و قوانین در سایت سلامت و تغذیه ایوا
        </h2>

        <div class="text-gray-800 space-y-4 text-sm leading-relaxed">

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#3e4095]">مرحله اول: ثبت پرسنل توسط سازمان در سایت ایوا</h3>
            <p class="font-semibold">قوانین:</p>
            <ul class="list-disc pr-6 space-y-1">
              <li>نام و کد یا کد پرسنلی هر فرد در ابتدا توسط شرکت در ایوا ثبت خواهد شد تا فرد مورد نظر سازمان امکان ثبت نام داشته باشد.</li>
              <li>شرکت میتواند از 0 تا 100٪ مبلغ هزینه تغذیه و سلامت پرسنل خود را در غالب سوبسید بر عهده بگیرد.</li>
              <li>شرکت تا مبلغ خاصی را شامل سوبسید میکند، لذا اگر فردی بیش از میزان تعیین شده خرید نماید فقط میتواند از تخفیف‌های ایوا استفاده نماید و شامل سوبسید نمیشود.</li>
            </ul>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#3e4095]">مرحله دوم:  ثبت‌نام پرسنل سازمان در ایوا</h3>
            <p>نام، کد پرسنلی، شماره تماس، پوزیشن سازمانی → دریافت کد یکبار مصرف از طریق پیامک و ورود به سایت.</p>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#3e4095]">مرحله سوم: انتخاب محصول</h3>
            <p>انتخاب بر اساس سبک محصول (لایت، انرژیک، رژیمی، کافئینی، مدرسه) یا از دسته‌بندی محصولات (اکونومی، سالاد، ساندویچ، میانوعده و ...)</p>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#3e4095]">مرحله چهارم: انتخاب روز در تقویم کاری</h3>
            <p>انتخاب روز مشخص برای خرید محصولات در سایت ایوا.</p>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#3e4095]">مرحله پنجم: نوع خرید</h3>
            <p>اعلام سایت بر اساس نوع خرید (روزانه، هفتگی یا ماهانه):</p>
            <ul class="list-disc pr-6 space-y-1">
              <li>با خرید ۲ روز: روزانه است.</li>
              <li>با خرید ۳ روز در هفته و ۱ تا ۳ هفته: هفتگی است.</li>
              <li>با خرید ۲ روز در هفته و ۴ هفته متوالی: ماهانه است.</li>
            </ul>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#ffa444]">الف: خرید روزانه</h3>
            <ul class="list-disc pr-6 space-y-1">
              <li>شامل ۱ یا ۲ روز در یک هفته است.</li>
              <li>هیچ تخفیفی لحاظ نمی‌شود.</li>
              <li>سوبسید شرکت تعلق نمی‌گیرد.</li>
              <li>زمان خاصی ندارد؛ هر فرد می‌تواند در هر زمانی خرید را ثبت کند.</li>
              <li>هزینه ارسال معادل ۵۰ هزار تومان بر عهده خریدار است.</li>
              <li>امکان کنسل کردن پس از پرداخت وجود ندارد.</li>
            </ul>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#ffa444]">ب: خرید هفتگی</h3>
            <p>حداقل ۳ مرتبه در هفته و شامل ۱ تا ۳ هفته متوالی است.</p>
            <ul class="list-disc pr-6 space-y-1">
              <li>مشمول ۲۰٪ تخفیف است.</li>
              <li>شامل سوبسید شرکت می‌گردد.</li>
              <li>باید حداقل ۴۸ ساعت قبل از تاریخ اولین خرید تنظیم شود.</li>
              <li>هزینه ارسال بین خریداران شرکت تقسیم می‌شود.</li>
              <li>امکان مشاهده تعداد نفرات خرید در تقویم برای محاسبه هزینه حمل.</li>
              <li>امکان کنسل کردن تا ۴۸ ساعت قبل از موعد وجود دارد.</li>
              <li>در صورت کنسلی، فقط هزینه کالا بازگردانده می‌شود؛ هزینه حمل مرجوع نمی‌شود.</li>
            </ul>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#ffa444]">پ: خرید ماهانه</h3>
            <p>حداقل ۲ مرتبه در هفته و شامل ۴ هفته متوالی است.</p>
            <ul class="list-disc pr-6 space-y-1">
              <li>مشمول ۴۰٪ تخفیف است.</li>
              <li>باید حداقل ۴۸ ساعت قبل از تاریخ اولین خرید تنظیم شود.</li>
              <li>شامل سوبسید شرکت می‌گردد.</li>
              <li>هزینه ارسال بین خریداران شرکت تقسیم می‌شود.</li>
              <li>امکان مشاهده تعداد نفرات خرید در تقویم برای محاسبه هزینه حمل.</li>
              <li>امکان کنسل کردن تا ۴۸ ساعت قبل از موعد وجود دارد.</li>
              <li>در صورت کنسلی، فقط هزینه کالا بازگردانده می‌شود؛ هزینه حمل مرجوع نمی‌شود.</li>
            </ul>
          </section>

          <section>
            <h3 class="font-semibold text-lg mb-2 text-[#338000]">مثال:</h3>
            <ul class="list-none pr-6 space-y-1">
              <li>خرید روزانه: ۲۰۰٬۰۰۰ + ۵۰٬۰۰۰ هزینه حمل = ۲۵۰٬۰۰۰ تومان</li>
              <li>خرید هفتگی: ۲۰۰٬۰۰۰ – ۲۰٪ = ۱۶۰٬۰۰۰ – سوبسید ۳۰٪ = ۱۱۷٬۰۰۰ + ۵٬۰۰۰ حمل = ۱۲۲٬۰۰۰ تومان</li>
              <li>خرید ماهانه: ۲۰۰٬۰۰۰ – ۴۰٪ = ۱۲۰٬۰۰۰ – سوبسید ۳۰٪ = ۸۲٬۰۰۰ + ۵٬۰۰۰ حمل = ۸۷٬۰۰۰ تومان</li>
            </ul>
            <p>در هر ۳ مدل، فرد می‌تواند در اسنپ‌پی پرداخت هزینه را به زمان دیگری موکول نماید.</p>
          </section>

        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted, computed } from "vue";

const props = defineProps({
  floating: {
    type: Boolean,
    default: true
  }
});

const emit = defineEmits(['update:modelValue']);

const open = ref(false);

const isAtTop = ref(true);
const isMobile = ref(false);

const isShrunk = computed(() => !isAtTop.value || isMobile.value);

const handleScroll = () => {
  if (props.floating) {
    isAtTop.value = window.scrollY < 50;
  }
};

const checkMobile = () => {
  isMobile.value = window.innerWidth < 768;
};

onMounted(() => {
  checkMobile();
  window.addEventListener('resize', checkMobile);
  if (props.floating) {
    window.addEventListener("scroll", handleScroll);
  }
});
onUnmounted(() => {
  window.removeEventListener('resize', checkMobile);
  if (props.floating) {
    window.removeEventListener("scroll", handleScroll);
  }
});
</script>
```
