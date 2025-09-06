"use client";
import { useSelection } from "./SelectionProvider";

export default function SetSummary() {
  const { selections } = useSelection();

  return (
    <div className="rounded bg-gray-100 p-4">
      <h2 className="mb-2 font-semibold">Summary</h2>
      {Object.keys(selections).length === 0 && (
        <p className="text-sm text-gray-600">No selections</p>
      )}
      <ul className="space-y-1">
        {Object.entries(selections).map(([facet, value]) => (
          <li key={facet}>
            <span className="font-medium">{facet}</span>: {value}
          </li>
        ))}
      </ul>
    </div>
  );
}
