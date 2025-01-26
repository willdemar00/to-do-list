<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\PasswordUpdateRequest;
use App\Services\ImageService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('frontend.profile.form', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        DB::beginTransaction();
        try {
            $user->fill($request->validated());

            if ($user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            if ($request->hasFile('image')) {
                if ($user->image) {
                    ImageService::updateImage($request->file('image'), $user);
                } else {
                    ImageService::storeImage($request->file('image'), $user);
                }
            }

            $user->save();

            DB::commit();
            return Redirect::route('profile.edit')->with('flash_success', 'Perfil atualizado com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Falha na atualização do perfil: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('flash_error', 'Falha ao atualizar o perfil.');
        }
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(PasswordUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        DB::beginTransaction();
        try {
            if (!Hash::check($request->current_password, $user->password)) {
                return Redirect::route('profile.edit')->with('flash_error', 'Senha atual incorreta.');
            }

            $user->password = Hash::make($request->new_password);
            $user->save();

            DB::commit();
            return Redirect::route('profile.edit')->with('flash_success', 'Senha atualizada com sucesso.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Falha na atualização da senha: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('flash_error', 'Falha ao atualizar a senha.');
        }
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $user = $request->user();

        DB::beginTransaction();
        try {
            if (!Hash::check($request->password, $user->password)) {
                return Redirect::route('profile.edit')->with('flash_error', 'Senha incorreta.');
            }

            Auth::logout();

            $user->delete();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            DB::commit();
            return Redirect::to('/');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Falha na exclusão da conta: ' . $e->getMessage());
            return Redirect::route('profile.edit')->with('flash_error', 'Falha ao excluir a conta.');
        }
    }
}
