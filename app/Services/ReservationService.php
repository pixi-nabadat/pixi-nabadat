<?php

namespace App\Services;

use App\Exceptions\StatusNotEquelException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Center;
use App\Models\User;
use App\Models\ReservationHistory;
use Exception;
class ReservationService extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Reservation::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try{
            return Center::all();
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array  $reservationData
     * @return \Illuminate\Http\Response
     */
    public function store(array $reservationData)
    {
        try{
            $reservation = Reservation::create($reservationData);
            $history = new ReservationHistory([
                'action_en' => Reservation::pending('en'),
                'action_ar' => Reservation::pending('ar')
            ]);
            $reservation->history()->save($history);
            return $reservation;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  Reservation  $Reservation
     * @return \Illuminate\Http\Response
     */
    public function show(Reservation $reservation)
    {
        try{
            return $reservation;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function edit(Reservation $reservation)
    {
        try{
            return $reservation;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function update(array $reservationData, Reservation $reservation, string $newAction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Reservation  $reservation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reservation $reservation)
    {
        try{
            $reservation->delete();
            return true;
        }catch(Exception $e){
            return $e->getMessage();
        }
    }

    public function confirm(User $user, Reservation $reservation){
        try{
            $lastStatus = $reservation->history->last()->action_en;
            if($lastStatus == Reservation::pending('en')){
                $reservation->history()->create([
                    'user_id'=>$user->id,
                    'action_en'=>Reservation::confirm('en'),
                    'action_ar'=>Reservation::confirm('ar')
                ]);
                return true;
            }else{
                throw new StatusNotEquelException('the status is: '.$lastStatus);
            }
            
            
        }catch(Exception $e){
            throw $e;
        }
    }
    public function attend(User $user, Reservation $reservation){
        try{
            $lastStatus = $reservation->history->last()->action_en;
            if($lastStatus == Reservation::confirm('en')){
                $reservation->history()->create([
                    'user_id'=>$user->id,
                    'action_en'=>Reservation::attend('en'),
                    'action_ar'=>Reservation::attend('ar')
                ]);
                return true;
            }else{
                throw new StatusNotEquelException('the status is: '.$lastStatus);
            }

        }catch(Exception $e){
            throw $e;
        }
    }
    public function complete(User $user, Reservation $reservation){
        try{
            $lastStatus = $reservation->history->last()->action_en;
            $reservationDevicesCount = $reservation->nabadatHistory->count();
            if($lastStatus == Reservation::attend('en') && $reservationDevicesCount > 0){
                $reservation->history()->create([
                    'user_id'=>$user->id,
                    'action_en'=>Reservation::completed('en'),
                    'action_ar'=>Reservation::completed('ar')
                ]);
                return true;
            }else{
                throw new StatusNotEquelException('status is: '.$lastStatus.' and devices is: '.$reservationDevicesCount);
            }

        }catch(Exception $e){
            throw $e;
        }
    }
    public function reservationDevices(array $data, Reservation $reservation){
        try{

        }catch(Exception $e){
            throw $e;
        }

    }
    public function cancel(User $user, Reservation $reservation)
    {
        try{
            $lastStatus = $reservation->history->last()->action_en;
            if($lastStatus != Reservation::completed('en') && $lastStatus != Reservation::canceled('en') && $lastStatus != Reservation::expired('en')){
                $reservation->history()->create([
                    'user_id'=>$user->id,
                    'action_en'=>Reservation::canceled('en'),
                    'action_ar'=>Reservation::canceled('ar')
                ]);
                return true;
            }else{
                throw new StatusNotEquelException('the status is: '.$lastStatus);
            }
                        
        }catch(Exception $e){
            throw $e;
        }
    }

}
