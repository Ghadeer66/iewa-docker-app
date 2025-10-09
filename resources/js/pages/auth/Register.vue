<script setup lang="ts">
import RegisteredUserController from '@/actions/App/Http/Controllers/Auth/RegisteredUserController';
import InputError from '@/components/InputError.vue';
import TextLink from '@/components/TextLink.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AuthBase from '@/layouts/AuthLayout.vue';
import { login } from '@/routes';
import { Form, Head } from '@inertiajs/vue3';
import { LoaderCircle } from 'lucide-vue-next';
</script>

<template>
    <AuthBase
        title="ثبت نام در ایوا"
    >
        <Head title="Register" />

        <!-- logo (replace Laravel logo) -->
        <div class="flex justify-center mb-6">
          <img src="/storage/images/icone.png" alt="ایوا" class="h-20 w-20 object-contain" />
        </div>

        <!-- apply brand color to text inside the form -->
        <Form
            v-bind="RegisteredUserController.store.form()"
            :reset-on-success="['password', 'password_confirmation']"
            v-slot="{ errors, processing }"
            class="flex flex-col gap-6 text-black"
        >
            <div class="grid gap-6">
                <div class="grid gap-2">
                    <Label for="name" class="text-black">نام و نام خانوادگی</Label>
                    <Input
                        id="name"
                        type="text"
                        required
                        autofocus
                        :tabindex="1"
                        autocomplete="name"
                        name="name"
                        placeholder=""
                    />
                    <InputError :message="errors.name" />
                </div>

                <div class="grid gap-2">
                    <Label for="email" class="text-black">ایمیل</Label>
                    <Input
                        id="email"
                        type="email"
                        required
                        :tabindex="2"
                        autocomplete="email"
                        name="email"
                        placeholder=""
                    />
                    <InputError :message="errors.email" />
                </div>

                <div class="grid gap-2">
                    <Label for="password" class="text-black">رمز عبور</Label>
                    <Input
                        id="password"
                        type="password"
                        required
                        :tabindex="3"
                        autocomplete="new-password"
                        name="password"
                        placeholder=""
                    />
                    <InputError :message="errors.password" />
                </div>

                <div class="grid gap-2">
                    <Label for="phone" class="text-black">شماره تلفن</Label>
                    <Input
                        id="phone"
                        type="phone"
                        required
                        :tabindex="4"
                        autocomplete="new-phone"
                        name="phone"
                        placeholder=""
                    />
                    <InputError :message="errors.phone" />
                </div>

                <Button
                    type="submit"
                    class="mt-2 w-full bg-black text-white"
                    tabindex="5"
                    :disabled="processing"
                    data-test="register-user-button"
                >
                    <LoaderCircle
                        v-if="processing"
                        class="h-4 w-4 animate-spin"
                    />
                     ثبت‌نام
                </Button>
            </div>

            <div class="text-center text-sm">
               حساب کاربری دارید؟
                <TextLink
                    :href="login()"
                    class="underline underline-offset-4 text-[#ffa800]"
                    :tabindex="6"
                    >ورود</TextLink
                >
            </div>
        </Form>
    </AuthBase>
</template>
