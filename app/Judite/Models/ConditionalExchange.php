<?php

namespace App\Judite\Models;

use Illuminate\Database\Eloquent\Model;

class ConditionalExchange extends Model
{
    /**
	 * Get exchanges of the conditional exchange
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\HasMany
	 */
    public function exchanges()
	{
		return $this->hasMany(Exchange::class);
	}

    /**
	 * Add exchange to this conditional exchange.
	 *
	 * @param \App\Judite\Models\Shift $shift
	 *
	 * @return $this
	 */
    public function addExchange(Exchange $exchange): self
	{
		$this->exchanges()->save($exchange);

		return $this;
	}

    /**
	 * Get the exchanges of this conditional exchange.
	 *
	 */
    public function getExchanges()
    {
        return $this->exchanges();
    }
}