import { render } from "@testing-library/react";
import ExhaustFanFacet from "@/app/configurator/ExhaustFanFacet";
import { useInfiniteQuery } from "@tanstack/react-query";
import { fetchCategoryArticles } from "@/lib/api";
import { useSelection } from "@/components/SelectionProvider";

jest.mock("@tanstack/react-query", () => ({
  useInfiniteQuery: jest.fn(),
}));

jest.mock("@/components/SelectionProvider", () => ({
  useSelection: jest.fn(),
}));

jest.mock("@/lib/api", () => ({
  fetchCategoryArticles: jest.fn(),
}));

describe("ExhaustFanFacet", () => {
  it("fetches exhaust fan articles", () => {
    (useSelection as jest.Mock).mockReturnValue({
      selections: { exhaustFan: null },
      setSelection: jest.fn(),
    });
    (useInfiniteQuery as jest.Mock).mockReturnValue({
      data: { pages: [{ items: [] }] },
      fetchNextPage: jest.fn(),
      hasNextPage: false,
      isFetchingNextPage: false,
    });

    render(<ExhaustFanFacet />);

    const options = (useInfiniteQuery as jest.Mock).mock.calls[0][0];
    expect(options.queryKey).toEqual(["exhaustFanArticles"]);
    options.queryFn({ pageParam: 1 });
    expect(fetchCategoryArticles).toHaveBeenCalledWith(
      "exhaust-fan",
      1,
      10,
      undefined,
    );
  });
});
